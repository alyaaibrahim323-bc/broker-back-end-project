<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sales;
use App\Events\NotificationEvent;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;


class SalesController extends Controller
{
    public function index(Request $request)
    {
        $query = Sales::query();


        // تحقق مما إذا كان هناك نص بحث في الطلب (type)
        if ($request->has('type') && $request->input('type') !== '') {
            // إضافة شرط للبحث في الاسم والبريد الإلكتروني
            $query->where('name', 'like', '%' . $request->input('type') . '%')
                  ->orWhere('email', 'like', '%' . $request->input('type') . '%');
        }

        // جلب السيلز بناءً على الاستعلام (مع أو بدون البحث)
        $sale = $query->get();
        // $sale =Sales::all();
        // $sale = Sales::orderBy('id', 'desc')->get();
         $sale =Sales::withCount('units')->orderBy('id', 'desc')->get();
        return view('adminUI.Employees.employeeshow', compact('sale'));
    }

    public function create()
    {
        return view('adminUI.Employees.add-employee');
    }

    public function save(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'contact_info' => 'nullable|string',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('uploads/sales', 'public');
        }

        $sale = Sales::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'contact_info' => $validatedData['contact_info'],
            'image' => $imagePath,
        ]);

        if ($sale) {
            // **إنشاء إشعار بعد إضافة البيع**
            $notification = Notification::create([
                'type' => 'create',
                'message' => "تمت إضافة عملية بيع جديدة: {$sale->name}",
                'user_id' => Auth::id(),
            ]);

            // **بث الإشعار**
            broadcast(new NotificationEvent($notification));

            session()->flash('success', 'Sale added successfully.');
            return redirect()->route('sales.show');
        } else {
            session()->flash('error', 'Failed to add sale.');
            return back()->withInput();
        }
    }


    public function show($id)
    {
        $sale = Sales::findOrFail($id);
        return view('sales.show', compact('sale'));
    }

    public function edit($id)
    {
        $sale = Sales::findOrFail($id);
        return view('adminUI.Employees.edit-employee', compact('sale'));
    }

    public function update(Request $request, $id)
    {
        $sale = Sales::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'contact_info' => 'nullable|string',
        ]);

        $sale->name = $validatedData['name'];
        $sale->email = $validatedData['email'];
        $sale->contact_info = $validatedData['contact_info'];

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('uploads/sales', 'public');
            $sale->image = $imagePath;
        }

        $sale->save();
         // **إنشاء إشعار بعد تحديث عملية البيع**
    $notification = Notification::create([
        'type' => 'update',
        'message' => "تم تحديث بيانات البيع: {$sale->name}",
        'user_id' => Auth::id(),
    ]);

    // **بث الإشعار**
    broadcast(new NotificationEvent($notification));

        return redirect()->route('sales.show')->with('success', 'Sale updated successfully.');
    }


    public function delete($id)
    {
        $sale = Sales::findOrFail($id);
        $sale->delete();

        return redirect()->route('sales.show')->with('success', 'Sale deleted successfully.');
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


}
