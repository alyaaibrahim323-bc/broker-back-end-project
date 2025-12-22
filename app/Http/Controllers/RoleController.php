<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::orderBy('name', 'ASC')->paginate(25);
        return view('adminUI.roles.list', [
            'roles' => $roles
        ]);
    }

    public function create()
    {
        $permissions = Permission::orderBy('name', 'ASC')->get();

        return view('adminUI.roles.create', [
            'permissions' => $permissions
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:roles|min:3'
        ]);

        if ($validator->passes()) {
            $role = Role::create(['name' => $request->name]);

            if (!empty($request->permission)) {
                foreach ($request->permission as $name) {
                    $role->givePermissionTo($name);
                }
            }

            return redirect()->route('roles.index')->with('success', 'Role added successfully.');
        } else {
            return redirect()->route('roles.create')->withInput()->withErrors($validator);
        }
    }

    public function edit($id)
    {
        $role = Role::findOrFail($id);

        if ($role->name === 'superadmin') {
            abort(403, 'Unauthorized action.');
        }

        if ($role->name === 'admin' && (!Auth::check() || !Auth::user()->hasRole('superadmin'))) {
            abort(403, 'Unauthorized action.');
        }

        $hasPermissions = $role->permissions->pluck('name');
        $permissions = Permission::orderBy('name', 'ASC')->get();

        return view('adminUI.roles.edit', [
            'permissions' => $permissions,
            'hasPermissions' => $hasPermissions,
            'role' => $role
        ]);
    }

    public function update($id, Request $request)
    {
        $role = Role::findOrFail($id);

        if ($role->name === 'superadmin') {
            abort(403, 'Unauthorized action.');
        }

        if ($role->name === 'admin' && (!Auth::check() || !Auth::user()->hasRole('superadmin'))) {
            abort(403, 'Unauthorized action.');
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:roles,name,' . $id . ',id'
        ]);

        if ($validator->passes()) {
            $role->name = $request->name;
            $role->save();

            if (!empty($request->permission)) {
                $role->syncPermissions($request->permission);
            } else {
                $role->syncPermissions([]);
            }

            return redirect()->route('roles.index')->with('success', 'Role updated successfully.');
        } else {
            return redirect()->route('roles.edit', $id)->withInput()->withErrors($validator);
        }
    }

    public function destroy($id)
    {
        $role = Role::find($id);
    
        if (!$role) {
            session()->flash('error', 'Role not found');
            return redirect()->route('roles.index'); // تأكد من وجود هذا المسار في routes
        }
    
        $deleted = $role->delete();
    
        if ($deleted) {
            session()->flash('success', 'Role Deleted Successfully');
            return redirect()->route('roles.index'); // إعادة التوجيه إلى قائمة الأدوار
        } else {
            session()->flash('error', 'Role Not Deleted Successfully');
            return redirect()->route('roles.index'); // إعادة التوجيه إلى قائمة الأدوار
        }
    }
    
}
