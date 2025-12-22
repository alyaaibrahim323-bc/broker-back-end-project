<?php

namespace App\Http\Controllers;

use App\Models\UserProperty;
use Illuminate\Http\Request;

class UserPropertyController extends Controller
{
    // دالة لعرض جميع بيانات المستخدمين
    public function index()
    {
        $userProperties = UserProperty::with('user')->get();
        return response()->json($userProperties);
    }

    // دالة لعرض بيانات المستخدم بناءً على `user_id`
    public function show($id)
    {
        $userProperty = UserProperty::with('user')->where('user_id', $id)->first();

        if (!$userProperty) {
            return response()->json(['message' => 'User property not found'], 404);
        }

        return response()->json($userProperty);
    }

    // دالة لإضافة بيانات جديدة للمستخدم
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id', // التأكد من أن المستخدم موجود
            'full_name' => 'nullable|string',
            'age' => 'nullable|integer',
            'marital_status' => 'nullable|string',
            'occupation' => 'nullable|string',
            'family_size' => 'nullable|integer',
            'monthly_income' => 'nullable|numeric',
            'preferred_location' => 'nullable|string',
            'lifestyle' => 'nullable|string',
            'climate_preference' => 'nullable|string',
            'family_status' => 'nullable|string',
            'special_needs' => 'nullable|boolean',
            'transport_nearby' => 'nullable|boolean',
        ]);

        $userProperty = UserProperty::create($request->all());

        return response()->json([
            'message' => 'User property created successfully',
            'data' => $userProperty
        ], 201);
    }

    // دالة لتحديث بيانات المستخدم
    public function update(Request $request, $id)
    {
        $request->validate([
            'full_name' => 'nullable|string',
            'age' => 'nullable|integer',
            'marital_status' => 'nullable|string',
            'occupation' => 'nullable|string',
            'family_size' => 'nullable|integer',
            'monthly_income' => 'nullable|numeric',
            'preferred_location' => 'nullable|string',
            'lifestyle' => 'nullable|string',
            'climate_preference' => 'nullable|string',
            'family_status' => 'nullable|string',
            'special_needs' => 'nullable|boolean',
            'transport_nearby' => 'nullable|boolean',
        ]);

        $userProperty = UserProperty::find($id);

        if (!$userProperty) {
            return response()->json(['message' => 'User property not found'], 404);
        }

        $userProperty->update($request->all());

        return response()->json([
            'message' => 'User property updated successfully',
            'data' => $userProperty
        ]);
    }

    // دالة لحذف بيانات المستخدم
    public function destroy($id)
    {
        $userProperty = UserProperty::find($id);

        if (!$userProperty) {
            return response()->json(['message' => 'User property not found'], 404);
        }

        $userProperty->delete();

        return response()->json([
            'message' => 'User property deleted successfully'
        ]);
    }
}
