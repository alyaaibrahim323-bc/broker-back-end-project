<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Developer;
use App\Models\Unit;
use App\Models\Project;
use App\Models\offer;
use App\Models\Sales;
use App\Models\Notification;
use App\Events\NotificationEvent;
use Illuminate\Support\Facades\Auth;





class DeveloperController extends Controller
{
    public function index(Request $request)
{
    $query = Developer::query();

    if ($request->has('type') && $request->input('type') !== '') {
        $query->where('name', 'like', '%' . $request->input('type') . '%')
              ->orWhere('contact_info', 'like', '%' . $request->input('type') . '%');
    }

    $developers = $query->get();

    return view('adminUI.Developers.Developersshow', compact('developers'));
}


    public function create()
    {

        $developers = Developer::all();

        return view('adminUI.Developers.add-developer', compact('developers'));
    }

    public function store(Request $request)
    {
        // تحقق من صحة البيانات المدخلة
        $request->validate([
            'name' => 'required|string|max:255',
            'contact_info' => 'nullable|string',
            'location' => 'nullable|string',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // تحقق من نوع الصورة
        ]);

        // جمع جميع البيانات المدخلة
        $data = $request->all();

        // تحقق إذا كانت الصورة مرفوعة
        if ($request->hasFile('image')) {
            // رفع الصورة وحفظها في المجلد المناسب
            $image = $request->file('image');
            $path = $image->store('images/developers', 'public');  // حفظ الصورة في المجلد المناسب
            $data['image'] = $path;  // حفظ المسار في الحقل `image` في قاعدة البيانات
        }

        // إنشاء Developer وتخزين البيانات في قاعدة البيانات
        $developer = Developer::create($data);
        $notification = Notification::create([
            'type' => 'create',
            'message' => "add New developer :$developer->name",
            'user_id' => Auth::id(),
        ]);

        // بث الإشعار
        broadcast(new NotificationEvent($notification,Auth::user()->name ));

        // إعادة التوجيه مع رسالة نجاح
        return redirect()->route('developers.show')->with('success', 'Developer created successfully.');
    }




    public function show($id)
    {
        $developer = Developer::findOrFail($id);
        return view('developers.show', compact('developer'));
    }

    public function edit($id)
    {
        // جلب المطور مع المشاريع والعروض المرتبطة به
        $developer = Developer::with(['projects', 'offers'])->findOrFail($id);

        // جلب العروض المرتبطة فقط بالمطور
        $offers = $developer->offers;

        // تمرير البيانات إلى العرض (View)
        return view('adminUI.Developers.edit-developer', compact('developer', 'offers'));
    }


    public function update(Request $request, $id)
    {
        $developer = Developer::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'contact_info' => 'nullable|string',
            'location' => 'nullable|string',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('images/developers', 'public');
        }

        $developer->update($data);
        $notification = Notification::create([
            'type' => 'update',
            'message' => "  update developer : {$developer->name}",
            'user_id' => Auth::id(),
        ]);

        broadcast(new NotificationEvent(  $notification ,Auth::user()->name));

        return redirect()->route('developers.show')->with('success', 'Developer updated successfully.');
    }

    public function destroy($id)
    {
        $developer = Developer::findOrFail($id);
        $developer->delete();

    $notification = Notification::create([
        'type' => 'delete',
        'message' => "delete developer  : {$developer->name}",
        'user_id' => Auth::id(),
    ]);

    broadcast(new NotificationEvent($notification,Auth::user()->name));

        return redirect()->route('developers.index')->with('success', 'Developer deleted successfully.');
    }

    public function showproperties($id){
                $developer = Developer::findOrFail($id);

        $developer = Developer::with('units')->findOrFail($id);
        return view('adminUI.Developers.units.developer-proprety', compact('developer'));
    }


    public function editproperty($id)
{
           $unit = Unit::findOrFail($id);
        $salespeople = Sales::all();
$developer = Developer::findOrFail($unit->developer_id);
        $projects = Project::all();
            $developers = Developer::all(); // ✅ هنا الإضافة

        return view('adminUI.Developers.units.edit-proprety', compact('unit','projects','salespeople','developer','developers'));
}


    public function createads()
    {
        $developers = Developer::all();

        return view('adminUI.Developers.ads.add-Ads', compact('developers'));
    }

    public function storeads(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'developer_id' => 'required|exists:developers,id',
            'phone_number' => 'required|string|max:20',
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('ads', 'public');
            $validatedData['image'] = $imagePath;
        }

        Ad::create($validatedData);

        return redirect()->route('developers.ads', $validatedData['developer_id'])->with('success', 'Advertisement created successfully.');
    }




}
