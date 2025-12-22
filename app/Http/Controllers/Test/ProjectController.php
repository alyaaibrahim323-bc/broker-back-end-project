<?php

namespace App\Http\Controllers\Test;

use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProjectController extends Controller
{
    // استرجاع كل المشاريع
    public function index()
    {
        return Project::all();
    }

    // إضافة مشروع جديد
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'is_for_sale' => 'required|boolean',
            'starting_area' => 'required|numeric',
            'down_payment' => 'required|numeric',
            'installment_type' => 'required|string',
        ]);

        return Project::create($request->all());
    }

    // استرجاع مشروع معين
    public function show($id)
    {
        return Project::findOrFail($id);
    }

    // تحديث بيانات المشروع
    public function update(Request $request, $id)
    {
        $project = Project::findOrFail($id);
        $project->update($request->all());

        return $project;
    }

    // حذف مشروع
    public function destroy($id)
    {
        $project = Project::findOrFail($id);
        $project->delete();

        return response()->json(['message' => 'Project deleted successfully']);
    }
}
