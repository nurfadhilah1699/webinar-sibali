<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Registration;
use App\Models\Event;
use App\Models\Team;
use Illuminate\Support\Str;

class RegistrationController extends Controller
{
    public function register(Request $request)
    {
        // 1. Validasi Tanpa payment_proof
        $request->validate([
            'event_id'      => 'required|exists:events,id',
            'package_type'  => 'required|in:full,basic,premium,lcc_team',
            'amount'        => 'required|numeric',
            'team_name'     => 'required_if:package_type,lcc_team|max:255',
            'school_name'   => 'required_if:package_type,lcc_team|max:255',
            'members'       => 'required_if:package_type,lcc_team|array|min:2|max:3',
            'members.*'     => 'required|string|max:255',
        ]);

        $teamId = null;
        $details = null;

        // 2. Logika LCC
        if ($request->package_type === 'lcc_team') {
            $team = Team::create([
                'team_name'   => $request->team_name,
                'school_name' => $request->school_name,
                'access_code' => strtoupper(Str::random(8)),
            ]);
            $teamId = $team->id;
            $details = ['members' => $request->members];
        } else {
            // Logika Webinar
            $details = $request->has('episodes') ? json_decode($request->episodes) : null;
        }

        // 3. Simpan ke REGISTRATIONS (payment_proof dikosongkan dulu)
        $registration = Registration::create([
            'user_id'       => auth()->id(),
            'event_id'      => $request->event_id,
            'team_id'       => $teamId,
            'package_type'  => $request->package_type,
            'amount'        => $request->amount,
            'payment_proof' => null, // PENTING: Kosongkan dulu
            'details'       => $details,
            'status'        => 'pending',
        ]);

        // 4. Redirect ke halaman payment bawa ID pendaftaran tadi
        return redirect()->route('payment.index', $registration->id);
    }

    public function showRegistrationForm($slug)
    {
        $event = Event::where('slug', $slug)->firstOrFail();
        $user = auth()->user();

        // Cari pendaftaran user di event ini
        $registration = Registration::where('user_id', $user->id)
                                    ->where('event_id', $event->id)
                                    ->first();

        if ($registration) {
            // JIKA BELUM UPLOAD BUKTI (Kolom payment_proof masih kosong)
            if (!$registration->payment_proof) {
                return redirect()->route('payment.index', $registration->id);
            }
            // JIKA SUDAH LENGKAP
            return redirect()->route('dashboard')->with('info', 'Kamu sudah terdaftar di event ini.');
        }

        // Tampilkan form sesuai tipe event
        $view = ($event->type === 'lcc') ? 'lcc.registration-form' : 'webinar.registration-form';
        return view($view, compact('event'));
    }

    public function payment(Registration $registration)
    {
        // Pastikan ini milik dia
        if ($registration->user_id !== auth()->id()) abort(403);

        // Kirim data registration ke view payment/index.blade.php
        return view('payment.index', compact('registration'));
    }

    public function confirmPayment(Request $request, Registration $registration)
    {
        $request->validate([
            'payment_proof' => 'required|image|max:2048',
        ]);

        if ($request->hasFile('payment_proof')) {
            $path = $request->file('payment_proof')->store('payments', 'public');
            
            $registration->update([
                'payment_proof' => $path,
                'status' => 'pending'
            ]);

            return redirect()->route('dashboard')->with('success', 'Bukti terkirim! Admin akan segera memverifikasi.');
        }
    }
}
