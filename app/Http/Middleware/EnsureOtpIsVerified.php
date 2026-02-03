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

        // JIKA user sudah login TAPI otp_code di database BELUM NULL (artinya belum verifikasi)
        if ($user && $user->otp_code !== null) {
            // Paksa tendang balik ke halaman input OTP
            return redirect()->route('otp.view')
                             ->with('error', 'Silakan masukkan kode OTP terlebih dahulu.');
        }

        return $next($request);
    }
}