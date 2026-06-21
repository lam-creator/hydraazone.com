<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Notifications\ResetPasswordNotification;
use Yajra\Datatables\Datatables;

class UserController extends Controller
{

    public function create()
    {
        return view('auth.user.register');
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3|max:80',
            'phone' => 'required|min:11|max:14|unique:users,phone',
            'email' => 'nullable|email|unique:users,email',
            'password' => 'required|confirmed|min:6|max:60', // 'confirmed' ensures password matches the confirmation field
        ]);

        $user = User::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        Auth::login($user);

        // $redirectUrl = route('user.dashboard');
        $redirectUrl = route('home');

        return response()->json([
            'status' => 'success',
            'redirect_url' => $redirectUrl
        ]);

    }

    // Show login page
    public function index()
    {
        if (Auth::check()) {
            return redirect()->route('user.dashboard');
        } else {
            return view('auth.user.login');
        }
        // End of code
    }


    // Login process
    public function LoginProcess(Request $request)
    {
        // Validate the request input
        $request->validate([
            'phone' => 'required|min:11|max:14',
            'password' => 'required|min:6|max:60',
        ]);

        // Get only the phone and password from the request
        $credentials = $request->only('phone', 'password');


        // Store the intended URL before login (this could be the checkout route)
        if (!$request->session()->has('url.intended')) {
            $request->session()->put('url.intended', route('user.checkout')); // You can change this to any route
        }

        // Attempt login using default guard (replace '' with a specific guard if needed)
        if (Auth::attempt($credentials)) {
            $user = Auth::user(); // Retrieve the authenticated user

            // Check if the user is active
            if ($user->status === 'active') { // Adjust the 'status' field if necessary

                // Determine the redirect URL based on the session flag
                $redirectUrl = session('came_from_checkout') ? session('url.intended') : route('user.dashboard');

                // Clear the session flag after use
                $request->session()->forget('came_from_checkout');

                return response()->json([
                    'status' => 'success',
                    'redirect_url' => $redirectUrl
                ]);

            } else {
                // Logout the user if they are not active
                Auth::logout();
                return response()->json([
                    'status' => 'error',
                    'message' => 'Sorry !!! Your account is not active.',
                ]);
            }
        } else {
            // Handle invalid credentials
            return response()->json([
                'status' => 'error',
                'message' => 'Sorry !!! You have entered invalid credentials.',
            ]);
        }
    }


    // Go to Dashboard
    public function dashboard()
    {
        if (Auth::check()) {
            $User = Auth::user();
            return view('front-end.dashboard', compact('User'));
        }
        $notification = array(
            'message' => 'Opps! You do not have access',
            'alert-type' => 'error'
        );
        return Redirect()->route('user.login')->with($notification);
        // End of code
    }


    // logout function
    public function logout()
    {
        // Clear all session data
        Auth::logout();
        Session::flush();

        $notification = [
            'message' => 'You have successfully logged out',
            'alert-type' => 'success',
        ];

        return redirect()->route('home')->with($notification);
    }

    // show change password page
    public function changePassword()
    {
        if (Auth::check()) {
            $user = Auth::user();
            return view('auth.user.change-password', compact('user'));
        } else {
            $notification = array(
                'message' => 'You must login to access this page',
                'alert-type' => 'error'
            );
            return Redirect()->route('user.login')->with($notification);
        }
        // End of code
    }

    // update user Password process
    public function updatePassword(Request $request, $id)
    {
        // Validate the request
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
            'new_password_confirmation' => 'required|min:6',
        ]);

        // Find the user by ID
        $user = User::findOrFail($id);

        // Check if the logged-in user is the same as the user being updated
        if (Auth::user()->id !== $user->id) {
            return redirect()->route('user.change-password')->withErrors(['error' => 'Unauthorized']);
        }

        // Check if the old password is correct
        if (!Hash::check($request->old_password, $user->password)) {
            return back()->withErrors(['old_password' => 'Old password is incorrect']);
        }

        // Update the user password
        $user->password = Hash::make($request->new_password);
        $user->save();

        // Log out the user (optional: if you want the user to log out after changing password)
        // Auth::logout();

        // Redirect with success message
        $notification = array(
            'message' => 'Password updated successfully',
            'alert-type' => 'success'
        );
        return Redirect()->route('user.change-password')->with($notification);
    }

    // update user profile process
    public function updateprofile(Request $request, $id)
    {
        // Validate the request
        $request->validate([
            'name' => 'required|min:3|max:80',
            'email' => 'nullable|min:3|max:80',
            // 'phone' => 'required|min:11|max:14',
            'address' => 'required|min:1|max:255',
        ]);

        // Find the user by ID
        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        // $user->phone = $request->phone;
        $user->address = $request->address;
        $user->save();

        // Redirect with success message
        $notification = array(
            'message' => 'Data updated successfully',
            'alert-type' => 'success'
        );
        return Redirect()->route('user.dashboard')->with($notification);

    }

    // Show forgot password form
    public function showForgotPasswordForm()
    {
        return view('auth.user.forgot-password');
    }

    // Handle forgot password request
    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);

        $user = User::where('email', $request->email)->first();

        if ($user) {
            $token = Str::random(64);

            // Store reset token in password_resets table
            DB::table('password_reset_tokens')->updateOrInsert(
                ['email' => $request->email],
                ['token' => $token, 'created_at' => now()]
            );

            // Send email notification
            $user->notify(new ResetPasswordNotification($token));
        }

        return back()->with('success', 'A password reset link has been sent to your email.');
    }

    // Show reset password form
    public function showResetForm($token)
    {
        return view('auth.user.reset-password', ['token' => $token]);
    }

    // Handle password reset
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        $tokenData = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->where('token', $request->token)
            ->first();

        if (!$tokenData) {
            return back()->withErrors(['email' => 'Invalid token or email.']);
        }

        // Update password
        $user = User::where('email', $request->email)->first();
        $user->password = Hash::make($request->password);
        $user->save();

        // Delete token
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return redirect()->route('user.login')->with('success', 'Your password has been reset successfully.');
    }



    // code for Customer list in admin panel
    public function Customer()
    {
        return view('back-end.pages.user.users');
    }


    public function CustomerData(Request $request)
    {
        $User = User::orderBy('id', 'desc')->get();

        return DataTables::of($User)

        // format date
        ->editColumn('created_at', function ($data) {
            return \Carbon\Carbon::parse($data->created_at)->format('Y-m-d');
        })

        ->rawColumns(['action'])
        ->toJson();
    }








    // End

}
