<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Developer;
use Illuminate\Support\Facades\Validator;
use App\Models\Notification;
use App\Events\NotificationEvent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;




class CompoundController extends Controller
{
    public function index(Request $request)
    {
        $query = Project::query();

        if ($request->has('type') && $request->input('type') !== '') {
            $searchTerm = $request->input('type');

            $query->where('name', 'like', '%' . $searchTerm . '%')
                  ->orWhere('location', 'like', '%' . $searchTerm . '%');
        }

        $compounds = $query->get();

        return view('adminUI.compounds.compoundsshow', compact('compounds'));
    }


    public function create()
    {
        $developers = Developer::all();

        return view('adminUI.compounds.add-compound', compact('developers'));

    }
    // public function add(Request $request)
    // {
    //     $developers = Developer::all();
    //     $developerId = $request->get('developer_id');

    //     return view('adminUI.compounds.project-add', compact('developers'));

    // }
    public function add(Request $request)
{
    $developers = Developer::all();
    return view('adminUI.compounds.add-compound', [
        'developers' => $developers,
        'developer_id' => $request->developer_id
    ]);
}


    public function store(Request $request)
    {

        // التحقق من صحة البيانات
        // $validator = Validator::make($request->all(), [
        //     'name' => 'required|string|max:255',
        //     'location' => 'required|string|max:255',
        //     'description' => 'nullable|string',
        //     'developer_id' => 'required|exists:developers,id',
        //     'is_for_sale' => 'nullable|boolean',
        //     'min_size' => 'nullable|integer',
        //     'down_payment' => 'nullable|numeric',
        //     'installment_options' => 'nullable|string',
        //     'unit_types' => 'nullable|string',
        //     'status' => 'nullable|in:under_construction,completed',
        //     'about' => 'nullable|string',
        //     'average_meter_price_from' => 'nullable|numeric',
        //     'average_meter_price_to' => 'nullable|numeric',
        //     'unit_area_to' => 'nullable|integer',
        //     'facilities' => 'nullable|string',
        //     'services' => 'nullable|string',
        //     'starting_price' => 'nullable|numeric',
        //     'maintenance_deposit_percentage' => 'nullable|numeric',
        //     'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        // ]);

        // if ($validator->fails()) {
        //     return redirect()->route('compounds.add')->withInput()->withErrors($validator);
        // }

        // معالجة الصورة
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('projects', 'public');
        }

        // إنشاء الـ project
        $compound = Project::create([
            'name' => $request->input('name'),
            'location' => $request->input('location'),
            'description' => $request->input('description'),
            'developer_id' => $request->input('developer_id'),
            'is_for_sale' => $request->input('is_for_sale', false),
            'min_size' => $request->input('min_size'),
            'down_payment' => $request->input('down_payment'),
            'installment_options' => $request->input('installment_options'),
            'unit_types' => $request->input('unit_types'),
            'status' => $request->input('status'),
            'about' => $request->input('about'),
            'average_meter_price_from' => $request->input('average_meter_price_from'),
            'average_meter_price_to' => $request->input('average_meter_price_to'),
            'unit_area_to' => $request->input('unit_area_to'),
            'facilities' => $request->input('facilities'),
            'services' => $request->input('services'),
            'starting_price' => $request->input('starting_price'),
            'maintenance_deposit_percentage' => $request->input('maintenance_deposit_percentage'),
            'image' => $imagePath,
        ]);

        // // إرسال إشعار للمستخدم
        // $notification = Notification::create([
        //     'type' => 'create',
        //     'message' => "Add new compound: {$compound->name}",
        //     'user_id' => Auth::id(),
        // ]);

        // broadcast(new NotificationEvent($notification, Auth::user()->name));

        return redirect()->route('compounds.show')->with('success', 'Compound created successfully.');
    }



    public function show($id)
    {
        $compound = Project::findOrFail($id);
        return view('adminUI.compounds.show', compact('compound'));

    }

    public function edit($id)
    {
        $compound = Project::findOrFail($id);
        $developers = Developer::all();

        return view('adminUI.compounds.edit-compound', compact('compound','developers'));
    }

       public function update(Request $request, $id)
{
    $compound = Project::findOrFail($id);

    $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'developer_id' => 'required|exists:developers,id',
        'location' => 'required|string|max:255',
        'starting_price' => 'required|numeric',
        'down_payment' => 'required|numeric|between:0,100',
        'installment_options' => 'required|integer|min:1',
        'maintenance_deposit_percentage' => 'required|numeric|between:0,100',
        'min_size' => 'required|numeric|min:1',
        'unit_area_to' => 'required|numeric|min:1',
        'average_meter_price_from' => 'nullable|numeric|min:0',
        'average_meter_price_to' => 'nullable|numeric|min:0',
        'status' => 'nullable|in:under_construction,completed',
        'unit_types' => 'nullable|string',
        'description' => 'nullable|string|min:50',
        'about' => 'nullable|string|min:100',
        'facilities' => 'nullable|string|min:50',
        'services' => 'nullable|string|min:50',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    if ($validator->fails()) {
        return redirect()->back()
            ->withErrors($validator)
            ->withInput();
    }

    $data = $request->except('_token', '_method');

    // Handle image upload
    if ($request->hasFile('image')) {
        // Delete old image if exists
        if ($compound->image && Storage::disk('public')->exists($compound->image)) {
            Storage::disk('public')->delete($compound->image);
        }

        $imagePath = $request->file('image')->store('compounds', 'public');
        $data['image'] = $imagePath;
    }

    $compound->update($data);

    // إنشاء إشعار بالتحديث
    Notification::create([
        'type' => 'update',
        'message' => "تم تحديث كمبوند: {$compound->name}",
        'user_id' => Auth::id(),
    ]);

    return redirect()->route('compounds.show')
        ->with('success', 'تم تحديث الكمبوند بنجاح');
}

    public function destroy($id)
    {
        $compound = Project::findOrFail($id);
        $compound->delete();
        $notification = Notification::create([
            'type' => 'delete',
            'message' => "delete compound  : {$compound->name}",
            'user_id' => Auth::id(),
        ]);

        broadcast(new NotificationEvent($notification,Auth::user()->name));
        return redirect()->route('compounds.index')->with('success', 'Compound deleted successfully.');
    }
}
