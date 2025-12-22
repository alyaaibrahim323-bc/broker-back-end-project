<?php

namespace App\Http\Controllers\Test;

use App\Models\Sales;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SalesController extends Controller
{
    // استرجاع كل المبيعات
    public function index()
    {
        return Sales::all();
    }

    // إضافة عملية بيع جديدة
    public function store(Request $request)
    {
        $request->validate([
            'unit_id' => 'required|exists:units,id',
            'sales_person_id' => 'required|exists:sales_people,id',
            'sale_price' => 'required|numeric',
        ]);

        return Sales::create($request->all());
    }

    // استرجاع عملية بيع معينة
    public function show($id)
    {
        return Sales::findOrFail($id);
    }

    // تحديث بيانات عملية البيع
    public function update(Request $request, $id)
    {
        $sale = Sales::findOrFail($id);
        $sale->update($request->all());

        return $sale;
    }

    // حذف عملية بيع
    public function destroy($id)
    {
        $sale = Sales::findOrFail($id);
        $sale->delete();

        return response()->json(['message' => 'Sale deleted successfully']);
    }
}
