<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Registration;
use App\Models\Event;

class RegistrationController extends Controller
{
    public function register(Request $request)
    {
        // 1. Validasi
        $request->validate([
            'event_id'     => 'required|exists:events,id',
            'package_type' => 'required|in:full,basic,premium',
            'amount'       => 'required|numeric',
            'episodes'     => 'required_if:package_type,basic', // Wajib jika pilih basic
        ]);

        // 2. Decode episodes (karena dikirim dalam bentuk JSON string dari Alpine)
        $episodesArray = json_decode($request->episodes);

        // 3. Simpan ke Database
        $registration = Registration::create([
            'user_id'      => auth()->id(),
            'event_id'     => $request->event_id,
            'package_type' => $request->package_type,
            'amount'       => $request->amount,
            'details'      => $episodesArray, // Laravel otomatis simpan jadi JSON karena casting di Model
            'status'       => 'pending',
        ]);

        // 4. Arahkan ke halaman instruksi pembayaran
        return redirect()->route('payment.index', $registration->id)
                         ->with('success', 'Pendaftaran berhasil disimpan!');
    }

    public function payment(Registration $registration)
    {
        // Pastikan hanya pemilik pendaftaran yang bisa lihat halaman ini
        if ($registration->user_id !== auth()->id()) {
            abort(403);
        }

        return view('payment.index', compact('registration'));
    }

    public function confirmPayment(Request $request, Registration $registration)
    {
        // 1. Validasi
        $request->validate([
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // 2. Pastikan yang upload adalah pemilik pendaftaran
        if ($registration->user_id !== auth()->id()) {
            abort(403);
        }

        // 3. Proses Simpan File
        if ($request->hasFile('payment_proof')) {
            $path = $request->file('payment_proof')->store('payments', 'public');
            
            // 4. Update tabel REGISTRATIONS (Bukan User)
            $registration->update([
                'payment_proof' => $path,
                'status' => 'pending' 
            ]);
        }

        return redirect()->route('dashboard')->with('success', 'Pembayaran berhasil dikonfirmasi! Mohon tunggu verifikasi admin.');
    }
}
