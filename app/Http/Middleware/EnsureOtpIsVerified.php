<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureOtpIsVerified
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        // 1. Jika belum login, biarkan middleware 'auth' yang menangani
        if (!$user) {
            return $next($request);
        }

        // 2. CEK: Apakah user sedang mengakses route OTP atau sedang Logout?
        // Ini kunci agar tidak "Layar Hitam"
        if ($request->routeIs('otp.*') || $request->routeIs('logout')) {
            return $next($request);
        }

        // 3. Jika otp_code masih ada (belum verifikasi), tendang ke halaman OTP
        if ($user->otp_code !== null) {
            return redirect()->route('otp.view');
        }

        return $next($request);
    }
}