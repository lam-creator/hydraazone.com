<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Admin;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
//use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
//use Illuminate\Support\Str;


class AdminAuthController extends Controller
{

    // Show login page
    public function index()
    {
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        } else {
            return view('auth/admin/login');
        }
        // End of code
    }

    // login process
    public function LoginProcess(Request $request)
    {
        $request->validate([
            'email' => 'required|email|max:100',
            'password' => 'required|min:8|max:40',

        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::guard('admin')->attempt($credentials)) {
            $admin = Auth::guard('admin')->user();

            if ($admin->status === 'active') { // Adjust this check based on your status field
                return response()->json([
                    'status' => 'success',
                    'redirect_url' => route('admin.dashboard')
                ]);
            } else {
                Auth::guard('admin')->logout();
                return response()->json([
                    'status' => 'error',
                    'message' => 'Sorry !!! Your account is not active.'
                ]);
            }
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Sorry !!! You have entered invalid credentials.'
            ]);
        }
        // End of code
    }

    // Go to Dashboard
    public function dashboard()
    {
        if (Auth::guard('admin')->check()) {
            $TotalAdmin = Admin::count();
            $TotalUser = User::count();
            $TotalProcessingOrder = Order::where('status', 'processing')->count();
            $TotalApprovedOrder = Order::where('status', 'approved')->count();
            $TotalDeliveredOrder = Order::where('status', 'delivered')->count();
            $TotalCancelledOrder = Order::where('status', 'cancelled')->count();
            return view('back-end.dashboard', compact('TotalAdmin', 'TotalUser', 'TotalProcessingOrder', 'TotalApprovedOrder', 'TotalDeliveredOrder', 'TotalCancelledOrder'));
        }
        $notification = array(
            'message' => 'Opps! You do not have access',
            'alert-type' => 'error'
        );
        return Redirect()->route('admin.login')->with($notification);
        // End of code
    }

    // logout function
    public function logout()
    {
        Session::flush();
        Auth::guard('admin')->logout();

        $notification = array(
            'message' => 'You have Successfully logged out',
            'alert-type' => 'success'
        );
        return Redirect()->route('admin.login')->with($notification);
        // End of code
    }

    // show change password page
    public function changePassword()
    {
        if (Auth::guard('admin')->check()) {
            $admin = Auth::guard('admin')->user();
            return view('back-end.pages.admin.profile', compact('admin'));
        } else {
            $notification = array(
                'message' => 'You must login to access this page',
                'alert-type' => 'error'
            );
            return Redirect()->route('admin.login')->with($notification);
        }
        // End of code
    }

    // update admin Password process
    public function updatePassword(Request $request, $id)
    {
        // Validate the request
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
            'new_password_confirmation' => 'required',
        ]);

        // Find the admin user by ID
        $admin = Admin::find($id);

        // Check if the old password is correct
        if (!Hash::check($request->old_password, $admin->password)) {
            return back()->withErrors(['old_password' => 'Old password is incorrect']);
        }

        // Update the admin password
        $admin->password = Hash::make($request->new_password);
        $admin->save();

        // Log out the admin user
        Auth::guard('admin')->logout();

        // Redirect to the login page
        $notification = array(
            'message' => 'Password updated successfully',
            'alert-type' => 'success'
        );
        return Redirect()->route('admin.login')->with($notification);
    }

    //
}