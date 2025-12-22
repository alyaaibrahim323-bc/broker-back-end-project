<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use App\Models\Developer;
use Illuminate\Http\Request;
use App\Models\Notification;
use App\Events\NotificationEvent;
use Illuminate\Support\Facades\Auth;

class OfferController extends Controller
{
    public function index(Request $request)
{
    // Start building the query for  offers
    $query = Offer::query();

    // Check if there's a search term (type) in the request
    if ($request->has('type') && $request->input('type') !== '') {
        // Add conditions to search in title and phone number
        $query->where('title', 'like', '%' . $request->input('type') . '%')
              ->orWhere('phone_number', 'like', '%' . $request->input('type') . '%');
    }

    // Fetch the offers based on the query (with or without search)
    $offers = $query->get();


    // Return the view with the offers
    return view('adminUI.offers.offersshow', compact('offers'));
}

    // Show the form to create a new offer
    public function create()
    {
        $developers = Developer::all(); // Fetch all developers to select from
        return view('adminUI.offers.add-offers', compact('developers'));
    }

    public function store(Request $request)
    {
        // Validate incoming request data
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'developer_id' => 'required|exists:developers,id',
            'phone_number' => 'required|string|max:20',
            'downpayment' => 'required|numeric|min:0',
            'installment_years' => 'required|integer|min:1',
        ]);

        // Upload image if provided
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('offers', 'public');
            $validatedData['image'] = $imagePath;
        }

        // Create the offer in the database
        $offer =  Offer::create($validatedData);
        // **إنشاء إشعار بعد إضافة العرض**
        $notification = Notification::create([
            'type' => 'create',
            'message' => "  add new offer: {$offer->title}",
            'user_id' => Auth::id(),
        ]);

        // **بث الإشعار باستخدام Laravel Reverb**
        broadcast(new NotificationEvent($notification,Auth::user()->name));

            // Redirect back with a success message
        return redirect()->route('offers.show')->with('success', ' offers Added Successfully.');
    }
    public function edit($id)
    {
        $developers = Developer::all();
        $offer = Offer::findOrFail($id);


        return view('adminUI.offers.details_offers', compact('offer', 'developers')); // تمرير العرض والمطورين إلى الـ view
    }

    public function update(Request $request, $id)
    {
        // تحقق من صحة البيانات
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'phone_number' => 'nullable|string|max:15',
            'developer_id' => 'required|exists:developers,id',
            'downpayment' => 'nullable|numeric',
            'installment_years' => 'nullable|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
        ]);

        // جلب العرض بناءً على الـ ID
        $offer = Offer::findOrFail($id);

        // تحديث البيانات
        $offer->title = $validatedData['title'];
        $offer->description = $validatedData['description'];
        $offer->phone_number = $validatedData['phone_number'];
        $offer->developer_id = $validatedData['developer_id'];
        $offer->downpayment = $validatedData['downpayment'];
        $offer->installment_years = $validatedData['installment_years'];

        // التحقق من رفع صورة
        if ($request->hasFile('image')) {
            // حذف الصورة القديمة إذا كانت موجودة
            if ($offer->image && file_exists(storage_path('app/public/' . $offer->image))) {
                unlink(storage_path('app/public/' . $offer->image));
            }

            // رفع الصورة الجديدة وحفظها في مجلد offers
            $imagePath = $request->file('image')->store('offers', 'public');
            $offer->image = $imagePath; // حفظ المسار الصحيح للصورة في قاعدة البيانات
        }
        // حفظ التغييرات
        $offer->save();

        // **إنشاء إشعار بعد تعديل العرض**
        $notification = Notification::create([
            'type' => 'update',
            'message' => "update offer  : {$offer->title}",
            'user_id' => Auth::id(),
        ]);

        // **بث الإشعار**
        broadcast(new NotificationEvent($notification,Auth::user()->name));


        // إعادة التوجيه مع رسالة نجاح
        return redirect()->route('offers.show', $offer->id)->with('success', 'Offer updated successfully!');
    }

    public function delete($id)
    {
        $offer = Offer::findOrFail($id);
        $offerTitle = $offer->title;

        $offer->delete();

        // **إنشاء إشعار بعد حذف العرض**
        $notification = Notification::create([
            'type' => 'delete',
            'message' => " delete offer : {$offerTitle}",
            'user_id' => Auth::id(),
        ]);

        // **بث الإشعار**
        broadcast(new NotificationEvent($notification,Auth::user()->name));

        return redirect()->route('offers.show')->with('success', 'Offer deleted successfully.');
    }






}
