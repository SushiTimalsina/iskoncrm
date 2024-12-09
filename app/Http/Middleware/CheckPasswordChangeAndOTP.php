<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use App\Notifications\OTPNotification;
use Carbon\Carbon;

class CheckPasswordChangeAndOTP
{
    public function handle($request, Closure $next)
    {
        $user = Auth::user();

        if ($user->password_change_required) {
            if (!$user->otp_code || $user->otp_expires_at < now()) {
                // Generate a new OTP
                $otp = rand(100000, 999999);
                $user->otp_code = $otp;
                $user->otp_expires_at = Carbon::now()->addMinutes(10); // OTP is valid for 10 minutes
                $user->save();

                // Send OTP to user's email
                Notification::send($user, new OTPNotification($otp));
            }

            return redirect()->route('password.change.otp');
        }

        return $next($request);
    }
}
