<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])
        ->name('register');

    Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
        ->name('password.request');

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name('password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset');

    Route::post('reset-password', [NewPasswordController::class, 'store'])
        ->name('password.store');
});

Route::middleware('auth')->group(function () {
    Route::get('verify-email', EmailVerificationPromptController::class)
        ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::put('password', [PasswordController::class, 'update'])->name('password.update');

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});

// --- Bagian Route OTP ---

// 1. Tampilan halaman input OTP
Route::get('verify-otp', function () {
    return view('auth.verify-otp');
})->middleware('auth')->name('otp.view');

// 2. Proses pengecekan OTP yang diinput user
Route::post('verify-otp', function (Request $request) {
    $request->validate([
        'otp' => 'required|numeric',
    ]);

    $user = Auth::user();

    // Cek apakah kode yang diinput sama dengan yang ada di database
    if ($request->otp == $user->otp_code) {
        $user->update([
            'email_verified_at' => now(), // Tandai email sudah valid
            'otp_code' => null,           // Hapus kode OTP agar tidak bisa dipakai lagi
        ]);

        return redirect()->route('dashboard')->with('status', 'Email berhasil diverifikasi!');
    }

    return back()->with('error', 'Kode OTP yang Anda masukkan salah.');
})->middleware('auth')->name('otp.verify');

Route::post('resend-otp', function () {
    $user = Auth::user();
    $otp = rand(100000, 999999);
    
    $user->update(['otp_code' => $otp]);

    \Mail::raw("Kode OTP baru Anda adalah: $otp", function ($message) use ($user) {
        $message->to($user->email)->subject('Resend Kode Verifikasi');
    });

    return back()->with('status', 'Kode OTP baru telah dikirim ke email Anda!');
})->middleware('auth')->name('otp.resend');
