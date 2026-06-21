<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
{
    // for permissions can be used in the controller
    protected function admin()
    {
        return Auth::guard('admin')->user();
    }


    // LIST
    public function index()
    {
        // Check if the user has permission to view roles list
        if (!$this->admin()->can('role.list')) {
            abort(403, 'Access denied');
        }

        $roles = Role::where('guard_name', 'admin')->get();
        return view('back-end.pages.admin.roles.index', compact('roles'));
    }

    // CREATE
    public function create()
    {
        // Check if the user has permission to create a role
        if (!$this->admin()->can('role.create')) {
            abort(403, 'Access denied');
        }

        $permissions = Permission::where('guard_name', 'admin')->get();
        return view('back-end.pages.admin.roles.create', compact('permissions'));
    }

    // SAVE
    public function store(Request $request)
    {
        // Check if the user has permission to create a role
        if (!$this->admin()->can('role.create')) {
            abort(403, 'Access denied');
        }

        $request->validate([
            'name' => 'required|unique:roles,name',
            'permissions' => 'array',
        ]);

        $role = Role::create([
            'name' => $request->name,
            'guard_name' => 'admin',
        ]);

        if ($request->has('permissions')) {
            $permissions = Permission::whereIn('id', $request->permissions)->pluck('name');
            $role->syncPermissions($permissions);
        }

        return redirect()->route('admin.roles.index')->with('success', 'Role created successfully.');
    }


    // EDIT
    public function edit($id)
    {
        // Check if the user has permission to edit a role
        if (!$this->admin()->can('role.edit')) {
            abort(403, 'Access denied');
        }

        $role = Role::findOrFail($id);
        $permissions = Permission::where('guard_name', 'admin')->get();
        return view('back-end.pages.admin.roles.edit', compact('role', 'permissions'));
    }

    // UPDATE
    public function update(Request $request, $id)
    {
        // Check if the user has permission to update a role
        if (!$this->admin()->can('role.edit')) {
            abort(403, 'Access denied');
        }

        $role = Role::findOrFail($id);

        $request->validate([
            'name' => 'required|unique:roles,name,' . $id,
            'permissions' => 'array',
        ]);

        $role->update([
            'name' => $request->name,
        ]);

        if ($request->has('permissions')) {
            // Convert permission IDs to names
            $permissions = Permission::whereIn('id', $request->permissions)->pluck('name');
            $role->syncPermissions($permissions);
        } else {
            $role->syncPermissions([]);
        }

        return redirect()->route('admin.roles.index')->with('success', 'Role updated successfully.');
    }

    // DELETE
    public function destroy($id)
    {
        // Check if the user has permission to delete a role
        if (!$this->admin()->can('role.delete')) {
            abort(403, 'Access denied');
        }
        
        $role = Role::findOrFail($id);
        $role->delete();

        return redirect()->route('admin.roles.index')->with('success', 'Role deleted successfully.');
    }



}