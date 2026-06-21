<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;

class PermissionController extends Controller
{
    // for permissions can be used in the controller
    protected function admin()
    {
        return Auth::guard('admin')->user();
    }

    // LIST
    public function index()
    {
        if (!$this->admin()->can('permission.list')) {
            abort(403, 'Access denied');
        }

        $permissions = Permission::where('guard_name', 'admin')->get();
        return view('back-end.pages.admin.permissions.index', compact('permissions'));
    }

    // CREATE
    public function create()
    {
        if (!$this->admin()->can('permission.create')) {
            abort(403, 'Access denied');
        }

        return view('back-end.pages.admin.permissions.create');
    }

    // SAVE
    public function store(Request $request)
    {
        if (!$this->admin()->can('permission.create')) {
            abort(403, 'Access denied');
        }

        $request->validate([
            'name' => 'required|unique:permissions,name',
        ]);

        Permission::create([
            'name' => $request->name,
            'guard_name' => 'admin',
        ]);

        return redirect()->route('admin.permissions.index')->with('success', 'Permission created successfully.');
    }

    // EDIT
    public function edit($id)
    {
        if (!$this->admin()->can('permission.edit')) {
            abort(403, 'Access denied');
        }

        $permission = Permission::findOrFail($id);
        return view('back-end.pages.admin.permissions.edit', compact('permission'));
    }

    // UPDATE
    public function update(Request $request, $id)
    {
        
        if (!$this->admin()->can('permission.edit')) {
            abort(403, 'Access denied');
        }

        $permission = Permission::findOrFail($id);

        $request->validate([
            'name' => 'required|unique:permissions,name,' . $id,
        ]);

        $permission->update([
            'name' => $request->name,
        ]);

        return redirect()->route('admin.permissions.index')->with('success', 'Permission updated successfully.');
    }

    // DELETE
    public function destroy($id)
    {
        if (!$this->admin()->can('permission.delete')) {
            abort(403, 'Access denied');
        }
        
        $permission = Permission::findOrFail($id);
        $permission->delete();

        return redirect()->route('admin.permissions.index')->with('success', 'Permission deleted successfully.');
    }

}