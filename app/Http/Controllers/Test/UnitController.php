<?php

namespace App\Http\Controllers\Test;

use App\Models\Unit;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UnitController extends Controller
{
    // استرجاع كل الوحدات
    public function index()
    {
        return Unit::all();
    }

    // إضافة وحدة جديدة
    public function store(Request $request)
    {
        $request->validate([
            'project_id' => 'required|exists:projects,id',
            'location' => 'required|string|max:255',
            'location_link' => 'nullable|string',
            'description' => 'nullable|string',
            'list_of_description' => 'nullable|array',
            'images' => 'nullable|array',
            'bathrooms' => 'required|integer',
            'rooms' => 'required|integer',
            'has_garden' => 'required|boolean',
            'garden_area' => 'nullable|numeric',
            'has_roof' => 'required|boolean',
            'roof_area' => 'nullable|numeric',
        ]);

        return Unit::create($request->all());
    }

    // استرجاع وحدة معينة
    public function show($id)
    {
        return Unit::findOrFail($id);
    }

    // تحديث بيانات الوحدة
    public function update(Request $request, $id)
    {
        $unit = Unit::findOrFail($id);
        $unit->update($request->all());

        return $unit;
    }

    // حذف وحدة
    public function destroy($id)
    {
        $unit = Unit::findOrFail($id);
        $unit->delete();

        return response()->json(['message' => 'Unit deleted successfully']);
    }
}
