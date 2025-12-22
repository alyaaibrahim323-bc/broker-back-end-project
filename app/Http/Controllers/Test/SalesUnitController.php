<?php

namespace App\Http\Controllers\Test;

use App\Models\SalesUnit;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SalesUnitController extends Controller
{
    // استرجاع كل وحدات البيع
    public function index()
    {
        return SalesUnit::all();
    }

    // إضافة وحدة بيع جديدة
    public function store(Request $request)
    {
        $request->validate([
            'sale_id' => 'required|exists:sales,id',
            'unit_id' => 'required|exists:units,id',
        ]);

        return SalesUnit::create($request->all());
    }

    // استرجاع وحدة بيع معينة
    public function show($id)
    {
        return SalesUnit::findOrFail($id);
    }

    // تحديث بيانات وحدة البيع
    public function update(Request $request, $id)
    {
        $salesUnit = SalesUnit::findOrFail($id);
        $salesUnit->update($request->all());

        return $salesUnit;
    }

    // حذف وحدة بيع
    public function destroy($id)
    {
        $salesUnit = SalesUnit::findOrFail($id);
        $salesUnit->delete();

        return response()->json(['message' => 'Sales Unit deleted successfully']);
    }
}
