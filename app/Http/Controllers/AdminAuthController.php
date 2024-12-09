<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;

class AdminAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('backend.auth.login');
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Retrieve the admin user by email
        $admin = Admin::where('email', $request->email)->first();

        // Check if admin exists and if their status is 'disabled'
        if ($admin && $admin->status === 'Deactivated') {
            return redirect()->back()->with('error', 'Your account has been disabled.');
        }

        // Retrieve the number of failed attempts from the session
        $attempts = session()->get('admin_login_attempts', 0);

        if ($attempts >= 5) {
            // If the user has tried more than 5 times, block further attempts
            $blockTime = session()->get('admin_login_block_time');

            if ($blockTime && now()->diffInMinutes($blockTime) < 5) {
                return back()->withErrors(['email' => 'Too many login attempts. Please try again after 5 minutes.']);
            }

            // Reset attempts after 10 minutes
            session()->forget('admin_login_attempts');
            session()->forget('admin_login_block_time');
        }

        // Attempt login
        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password], $request->filled('remember'))) {
            session()->forget('admin_login_attempts'); // Clear on successful login
            return redirect()->intended('/admin/home');
        }

        // Increment the failed attempt count
        session()->put('admin_login_attempts', $attempts + 1);

        // If the user has now reached 5 attempts, block further login attempts
        if ($attempts + 1 >= 5) {
            session()->put('admin_login_block_time', now());
        }
        // If unsuccessful, redirect back with an error
        return redirect()->back()->with('error', 'Invalid credentials.');
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }
}
