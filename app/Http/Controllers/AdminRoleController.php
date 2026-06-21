<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class AdminRoleController extends Controller
{
    // for permissions can be used in the controller
    protected function admin()
    {
        return Auth::guard('admin')->user();
    }

    public function index()
    {
        if (!$this->admin()->can('admin.list')) {
            abort(403, 'Access denied');
        }
        
        $admins = Admin::with('roles')->get();
        return view('back-end.pages.admin.admins.index', compact('admins'));
    }

    public function create()
    {
        if (!$this->admin()->can('admin.create')) {
            abort(403, 'Access denied');
        }

        $roles = Role::where('guard_name', 'admin')->get();
        return view('back-end.pages.admin.admins.create', compact('roles'));
    }

    public function store(Request $request)
    {
        if (!$this->admin()->can('admin.create')) {
            abort(403, 'Access denied');
        }

        $request->validate([
            'name'     => 'required|string|max:255',
            'username'     => 'required|string|max:255',
            'email'    => 'required|email|unique:admins,email',
            'password' => 'required|string|min:6|confirmed',
            'status'   => 'required|in:active,inactive',
            'roles'    => 'array',
        ]);

        $admin = Admin::create([
            'name'     => $request->name,
            'username'     => $request->username,
            'email'    => $request->email,
            'status'    => $request->status,
            'password' => Hash::make($request->password),
        ]);

        if ($request->has('roles')) {
            $admin->syncRoles($request->roles);
        }

        return redirect()->route('admin.admins.index')->with('success', 'Admin created successfully.');
    }

    public function edit($id)
    {
        if (!$this->admin()->can('admin.edit')) {
            abort(403, 'Access denied');
        }

        $admin = Admin::findOrFail($id);
        $roles = Role::where('guard_name', 'admin')->get();
        return view('back-end.pages.admin.admins.edit', compact('admin', 'roles'));
    }

    public function update(Request $request, $id)
    {
        if (!$this->admin()->can('admin.edit')) {
            abort(403, 'Access denied');
        }
        
        $admin = Admin::findOrFail($id);

        $request->validate([
            'name'     => 'required|string|max:255',
            'username'     => 'required|string|max:255',
            'email'    => 'required|email|unique:admins,email,' . $id,
            'password' => 'nullable|string|min:6|confirmed',
            'status'   => 'required|in:active,inactive',
            'roles'    => 'array',
        ]);

        $admin->name  = $request->name;
        $admin->username  = $request->username;
        $admin->email = $request->email;
        $admin->status = $request->status;

        if ($request->filled('password')) {
            $admin->password = Hash::make($request->password);
        }

        $admin->save();

        if ($request->has('roles')) {
            $admin->syncRoles($request->roles);
        } else {
            $admin->syncRoles([]);
        }

        return redirect()->route('admin.admins.index')->with('success', 'Admin updated successfully.');
    }

    public function destroy($id)
    {
        if (!$this->admin()->can('admin.delete')) {
            abort(403, 'Access denied');
        }
        
        $admin = Admin::findOrFail($id);
        $admin->delete();

        return redirect()->route('admin.admins.index')->with('success', 'Admin deleted successfully.');
    }


}