<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;


class permissioncontroller extends Controller 
{
    
    

    // this method will show permission page
    public function index()
    {
        $permissions = Permission::orderBy('created_at', 'DESC')->paginate(25);
        return view('adminUI.permissions.list',[
            'permissions'=> $permissions
        ]);
            
    }

    // this method will show create permission page
    public function create()
    {
        return view('adminUI.permissions.create');
    }

    // this method will insert permission in DB
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|unique:permissions|min:3'
        ]);

        if($validator->passes()){
            Permission::create(['name' => $request->name]);
            return redirect()->route('permissions.index')->with('success', 'Permission added successfully. ');
            
        }else{
            return redirect()->route('adminUI.permissions.create')->withInput()->withErrors($validator);
        }
    }

    // this method will edit permission page
    public function edit($id)
    {
        $permission = Permission::findOrFail($id);
        return view('adminUI.permissions.edit',[
            'permission' => $permission
        ]);

    }

    // this method will update a permission 
    public function update($id, Request $request)
    {
        $permission = Permission::findOrFail($id);

        $validator = Validator::make($request->all(),[
            'name' => 'required|min:3|unique:permissions,name,'.$id.',id'
        ]);

        if($validator->passes()){
            
            $permission->name = $request->name;
            $permission->save();

            return redirect()->route('permissions.index')->with('success', 'Permission updated successfully. ');
            
        }else{
            return redirect()->route('permissions.edit', $id)->withInput()->withErrors($validator);
        }
    }

    // this method will delete a permission in DB
    public function delete($id)
{
    // العثور على الـ permission بناءً على الـ id
    $permission = Permission::find($id);

    if (!$permission) {
        session()->flash('error', 'Permission not found');
        return redirect(route('permissions.index')); // يمكنك تعديل المسار حسب الحاجة
    }

    // محاولة الحذف
    $deleted = $permission->delete();

    if ($deleted) {
        session()->flash('success', 'Permission deleted successfully');
    } else {
        session()->flash('error', 'Failed to delete permission');
    }

    return redirect(route('permissions.index')); // إعادة التوجيه إلى قائمة الـ permissions
}

    

    
}