<?php

namespace App\Http\Controllers;

use App\Models\CustomerSupportRequest;
use Illuminate\Http\Request;

class CustomerSupportController extends Controller
{
    // دالة لإنشاء طلب دعم جديد
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id', // التحقق من أن user_id موجود في جدول users
            'message' => 'required|string',
        ]);

        // إنشاء طلب دعم جديد
        $supportRequest = CustomerSupportRequest::create([
            'user_id' => $request->user_id,  // التعديل هنا ليكون user_id بدلاً من customer_id
            'message' => $request->message,
        ]);

        return response()->json([
            'message' => 'Support request submitted successfully',
            'data' => $supportRequest,
        ], 201);
    }

    // دالة لعرض جميع طلبات الدعم
    public function index()
    {
        // جلب جميع طلبات الدعم مع المستخدم المرتبط بكل طلب
        $supportRequests = CustomerSupportRequest::with('user')->get();

        return response()->json($supportRequests);
    }

    // دالة لتحديث حالة الطلب
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Pending,Resolved,Closed', // التحقق من حالة الطلب
        ]);

        // جلب طلب الدعم باستخدام المعرف
        $supportRequest = CustomerSupportRequest::findOrFail($id);
        // تحديث حالة الطلب
        $supportRequest->status = $request->status;
        $supportRequest->save();

        return response()->json([
            'message' => 'Support request status updated successfully',
            'data' => $supportRequest,
        ]);
    }

    // دالة لعرض طلب معين بناءً على المعرف
    public function show($id)
    {
        // جلب طلب الدعم مع البيانات المرتبطة بالمستخدم
        $supportRequest = CustomerSupportRequest::with('user')->findOrFail($id);

        return response()->json($supportRequest);
    }
}
