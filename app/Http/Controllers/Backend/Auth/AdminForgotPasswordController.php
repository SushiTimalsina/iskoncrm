<?php

namespace App\Http\Controllers\Backend\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Password;

class AdminForgotPasswordController extends Controller
{
    use SendsPasswordResetEmails;

    public function __construct()
    {
        $this->middleware('guest');
    }

    // Show the form to request a password reset link for admin
    public function showLinkRequestForm()
    {
        return view('backend.auth.passwords.email');
    }

    // Use the admin password broker
    protected function broker()
    {
        return Password::broker('admins');
    }
}
