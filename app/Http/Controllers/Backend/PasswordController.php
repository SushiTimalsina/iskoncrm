<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class PasswordController extends Controller
{
    public function showOTPForm()
    {
        return view('auth.passwords.otp'); // Create this view for the OTP form
    }

    public function verifyOTP(Request $request)
    {
        $request->validate(['otp_code' => 'required|numeric']);

        $user = Auth::user();

        if ($user->otp_code == $request->otp_code && $user->otp_expires_at > Carbon::now()) {
            // OTP is valid, redirect to password change form
            return redirect()->route('password.change');
        }

        return back()->withErrors(['otp_code' => 'The OTP code is invalid or expired.']);
    }

    public function showChangePasswordForm()
    {
        return view('auth.passwords.change'); // Create this view for the password change form
    }

    public function updatePassword(Request $request)
    {
        $request->validate(['password' => 'required|confirmed|min:8']);

        $user = Auth::user();
        $user->password = Hash::make($request->password);
        $user->password_change_required = false;
        $user->otp_code = null;
        $user->otp_expires_at = null;
        $user->save();

        return redirect()->route('home')->with('status', 'Password changed successfully!');
    }
}
