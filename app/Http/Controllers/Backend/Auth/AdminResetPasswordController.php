<?php

namespace App\Http\Controllers\Backend\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Password;

class AdminResetPasswordController extends Controller
{
    use ResetsPasswords;

    protected $redirectTo = '/admin/home';

    public function redirectTo()
    {
        return $this->redirectTo; // Redirect to /admin/dashboard after password reset
    }

    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function sendResetResponse(Request $request, $response)
    {
        return redirect($this->redirectPath())->with('status', trans($response));
    }

    // Show the form to reset the password
    public function showResetForm(Request $request, $token = null)
    {
        return view('backend.auth.passwords.reset')->with([
            'token' => $token,
            'email' => $request->email
        ]);
    }

    // Use the admin password broker
    protected function broker()
    {
        return Password::broker('admins');
    }

    // Specify the guard to use during password reset
    protected function guard()
    {
        return auth()->guard('admin');
    }
}
