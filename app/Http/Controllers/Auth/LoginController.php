<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/user-dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth:user')->only('logout');
    }

    protected function authenticated(Request $request, $user)
    {
        // Check if the user's status is 'blocked'
        if ($user->status === 'Deactivated') {
            // Log the user out immediately
            Auth::guard('user')->logout();

            // Redirect to the login page with an error message
            return redirect('/login')->withErrors([
                'email' => 'Your account is blocked. Please contact support for assistance.',
            ]);
        }

        // If the status is 'active', proceed with the normal flow
        return redirect()->intended($this->redirectPath());
    }
}
