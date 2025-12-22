<?php

namespace App\Http\Controllers\Test;

use App\Models\Developer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DeveloperController extends Controller
{
    // استرجاع كل المطورين
    public function index()
    {
        return Developer::all();
    }

    // إضافة مطور جديد
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'contact_info' => 'nullable|string',
        ]);

        return Developer::create($request->all());
    }

    // استرجاع مطور معين
    public function show($id)
    {
        return Developer::findOrFail($id);
    }

    // تحديث بيانات المطور
    public function update(Request $request, $id)
    {
        $developer = Developer::findOrFail($id);
        $developer->update($request->all());

        return $developer;
    }

    // حذف مطور
    public function destroy($id)
    {
        $developer = Developer::findOrFail($id);
        $developer->delete();

        return response()->json(['message' => 'Developer deleted successfully']);
    }
}
