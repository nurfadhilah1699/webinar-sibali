<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // 1. Validasi Input
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'phone' => ['required', 'string', 'max:20'],
            'user_category' => ['required', 'string'],
            'institution' => ['required', 'string'],
            'address' => ['required', 'string'],
            'package' => ['required', 'string', 'in:reguler,vip1,vip2'],
        ]);

        // 2. Generate OTP
        $otp = rand(100000, 999999);

        // 3. Simpan User ke Database (Hanya satu kali Create!)
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user',
            'phone' => $request->phone,
            'user_category' => $request->user_category,
            'institution' => $request->institution,
            'address' => $request->address,
            'package' => $request->package,
            'otp_code' => $otp, // Pastikan kolom ini sudah ada di database (hasil migrate)
        ]);

        // 4. Jalankan Event Registered (Opsional, bawaan Breeze)
        event(new Registered($user));

        // 5. Kirim Email OTP
        try {
            \Mail::raw("Halo {$user->name}, Kode OTP verifikasi Anda adalah: $otp", function ($message) use ($user) {
                $message->to($user->email)
                        ->from(config('mail.from.address'), config('mail.from.name')) // TAMBAHKAN INI
                        ->subject('Kode Verifikasi Akun - Sibali.id');
            });
        } catch (\Exception $e) {
            // Jika email gagal kirim (salah config), user tetap terbuat tapi kasih peringatan
        }

        // 6. Login-kan User
        Auth::login($user);

        // 7. Arahkan ke halaman input OTP (BUKAN ke dashboard langsung)
        return redirect()->route('otp.view');
    }
}
