<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Developer;

use App\Models\Sales;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;
use App\Events\NotificationEvent;





use Illuminate\Http\Request;

class UIcontroller extends Controller
{
    // public function index()
    // {
    //     $salesData = $this->getSalesAndUnits();
    //     $notifications = Notification::orderBy('created_at', 'desc')->take(10)->get();

    //     $arabicMonths = [
    //         1 => 'يناير', 2 => 'فبراير', 3 => 'مارس', 4 => 'أبريل',
    //         5 => 'مايو', 6 => 'يونيو', 7 => 'يوليو', 8 => 'أغسطس',
    //         9 => 'سبتمبر', 10 => 'أكتوبر', 11 => 'نوفمبر', 12 => 'ديسمبر'
    //     ];

    //     // جلب بيانات المطورين
    //     $developers = Developer::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
    //         ->groupBy('month')
    //         ->pluck('count', 'month');

    //     // جلب بيانات المشاريع
    //     $projects = Project::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
    //         ->groupBy('month')
    //         ->pluck('count', 'month');

    //     // تهيئة البيانات لجميع الأشهر
    //     $labels = [];
    //     $developerData = [];
    //     $projectData = [];

    //     foreach (range(1, 12) as $month) {
    //         $labels[] = $arabicMonths[$month];
    //         $developerData[] = $developers->has($month) ? $developers[$month] : 0;
    //         $projectData[] = $projects->has($month) ? $projects[$month] : 0;
    //     }

    //     $data = [
    //         'labels' => $labels,
    //         'developers' => $developerData,
    //         'projects' => $projectData,
    //     ];



    //     return view('adminUI.dashboardui', compact('salesData','notifications','data'));
    // }

          public function index()
{
    // إحصائيات المبيعات
    $salesData = $this->getSalesAndUnits();

    // الإشعارات
    $notifications = Notification::orderBy('created_at', 'desc')->take(10)->get();


    // بيانات الرسوم البيانية
    $chartData = $this->getChartData();
    $doughnutData = $this->getDoughnutData();
    $barData = $this->getBarData();
$stats = $this->getActiveUsersStats();    // إحصائيات المستخدمين الجدد
    $newUsersCount = User::where('created_at', '>=', Carbon::now()->subDays(30))->count();

    // حساب النسبة المئوية للتغيير
    $previousPeriodStart = Carbon::now()->subMonths(2)->startOfMonth();
    $previousPeriodEnd = Carbon::now()->subMonths(1)->endOfMonth();
    $previousUsersCount = User::whereBetween('created_at', [$previousPeriodStart, $previousPeriodEnd])->count();

    $percentageChange = 0;
    if ($previousUsersCount > 0) {
        $percentageChange = (($newUsersCount - $previousUsersCount) / $previousUsersCount) * 100;
    }

    // التحقق من المصادقة
    if (!auth()->check()) {
        return redirect()->route('login');
    }

    return view('adminUI.dashboardui', array_merge(
    compact(
        'salesData',
        'notifications',
        'chartData',
        'doughnutData',
        'barData',
        'newUsersCount',
        'percentageChange'
    ),
    [
        'activeUsers' => $stats['activeUsers'],
        'changePercent' => $stats['changePercent'],
    ]
));

}


    public function getSalesAndUnits()
    {
        // إجمالي عدد المبيعات
        $salesCount = Sales::count();

        // إجمالي عدد الوحدات المرتبطة بجميع المبيعات
        $unitsCount = Sales::with('units')
            ->get()
            ->reduce(function ($total, $sale) {
                return $total + $sale->units->count();
            }, 0);

        return [
            'sales_count' => $salesCount,
            'units_count' => $unitsCount,
        ];
    }


    public function showProperties(Request $request)
    {
        $query = Unit::with('sales');

        // تحقق إذا كان هناك نوع بحث
        if ($request->has('type') && $request->input('type') != '') {
            $query->where('type', 'LIKE', '%' . $request->input('type') . '%');
        }

        $units = $query->orderBy('id', 'desc')->get();
        $total = $units->count();

        return view('adminUI.Properties.Propertiesshow', compact('units', 'total'));
    }


    public function delete($id)
    {
        $unit = Unit::findOrFail($id);
        $unit->delete();
        $unitName = $unit->property_name;

        // Create the delete notification
        $notification = Notification::create([
            'type' => 'delete',
            'message' => " delete unit : {$unitName}",
            'user_id' => Auth::id(),
        ]);

        // Broadcast the event
        broadcast(new NotificationEvent($notification,Auth::user()->name));
        session()->flash('success', 'Unit Deleted Successfully');
        return redirect()->back(); // Redirects back to the previous page
    }

    public function add()
    {
        $salespeople = Sales::all();
        return view('adminUI.Properties.add-property');
    }

    public function input()
    {
        $salespeople = Sales::all();
        $projects = Project::all();
        return view('adminUI.Properties.add-unit');
    }

    // في NotificationController.php
    public function markAsRead(Notification $notification)
    {
        if ($notification->user_id != auth::id()) {
            abort(403);
        }

        $notification->update(['is_read' => true]);

        return response()->json(['success' => true]);
    }
    public function getUnreadNotifications()
    {
        $unreadNotifications = auth()->user()->notifications()->where('is_read', false)->get();
        return response()->json($unreadNotifications);
    }

private function getChartData()
{
    $englishMonths = [
        1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April',
        5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August',
        9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'
    ];

    $developers = Developer::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
        ->groupBy('month')
        ->pluck('count', 'month');

    $projects = Project::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
        ->groupBy('month')
        ->pluck('count', 'month');

    $labels = [];
    $developerData = [];
    $projectData = [];

    foreach (range(1, 12) as $month) {
        $labels[] = $englishMonths[$month];
        $developerData[] = $developers->has($month) ? $developers[$month] : 0;
        $projectData[] = $projects->has($month) ? $projects[$month] : 0;
    }

    return [
        'labels' => $labels,
        'developers' => $developerData,
        'projects' => $projectData,
    ];
}
private function getDoughnutData()
{
    return [
        'labels' => ['Label 1', 'Label 2', 'Label 3'],
        'values' => [30, 50, 20],
        'colors' => ['#FF6384', '#36A2EB', '#FFCE56']
    ];
}

// دالة إرجاع بيانات العمودي (Bar Chart)
private function getBarData()
{
    return [
        'labels' => ['zayed', 'october', 'north..', '5th sett..', 'Gouna','New za..'],
        'values' => [20, 30, 15, 45, 30,60],
        'color' => '#4BC0C0'
    ];
}

private function getActiveUsersStats()
{
    $activeUsers = User::where('is_online', true)->count();

    $previousActiveUsers = User::where('is_online', true)
        ->where('updated_at', '<', Carbon::now()->subDay())
        ->count();

    $changePercent = 0;
    if ($previousActiveUsers > 0) {
        $changePercent = (($activeUsers - $previousActiveUsers) / $previousActiveUsers) * 100;
    }

    return [
        'activeUsers' => $activeUsers,
        'changePercent' => $changePercent,
    ];
}




}

