<?php

namespace App\Http\Middleware;

use App\Mail\VerificationEmail;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class EnsureEmailIsVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        if ($user) {
            if ($user->email_verified_at == null) {
                $verification_code = Str::random(6);
                Mail::to($user->email)->send(new VerificationEmail($user, $verification_code));
                Cache::put('verification_code.'.$user->id, $verification_code, now()->addMinutes(10));
                return redirect()->route('verify-email');
            }
        }
        return $next($request);
    }
}
