<?php
namespace App\Http\Controllers;

use App\Models\Developer;
use App\Models\Project;
use App\Models\Unit;
use App\Models\Sales;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function storeDeveloper(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'contact_info' => 'required|string',
        ]);

        $developer = Developer::create($request->all());
        return response()->json(['message' => 'Developer created successfully', 'data' => $developer], 201);
    }

    public function storeProject(Request $request)
    {
        // تحقق من المدخلات
        $request->validate([
            'developer_id' => 'required|exists:developers,id',
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'is_for_sale' => 'required|boolean',
            'min_size' => 'required|integer',
            'down_payment' => 'required|numeric',
            'installment_options' => 'nullable|string',
            'unit_types' => 'nullable|string',
        ]);

        // إنشاء مشروع جديد
        $project = Project::create($request->all());

        return response()->json($project, 201);
    }


    public function storeUnit(Request $request)
{
    $request->validate([
        'project_id' => 'required|exists:projects,id',
        'type' => 'required|string|max:255',
        'size' => 'required|integer',
        'price' => 'required|numeric',
        'location' => 'nullable|string|max:255',
        'location_link' => 'nullable|url',
        'description' => 'nullable|string',
        'list_of_description' => 'nullable|json',
        'images' => 'nullable|json',
        'bathrooms' => 'required|integer',
        'rooms' => 'required|integer',
        'has_garden' => 'boolean',
        'garden_size' => 'nullable|integer',
        'has_roof' => 'boolean',
        'roof_size' => 'nullable|integer',
        'status' => 'in:available,reserved,sold',
    ]);

    dd($request->all());

    try {
        $unit = Unit::create($request->all());
        return response()->json($unit, 201);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}

    

    public function storeSale(Request $request)
    {
        $request->validate([
            'unit_id' => 'required|integer',
            'sales_person_id' => 'required|integer',
            'sale_price' => 'required|integer',
            'payment_method' => 'required|string',
        ]);

        $sale = Sales::create($request->all());
        return response()->json(['message' => 'Sale created successfully', 'data' => $sale], 201);
    }
}
