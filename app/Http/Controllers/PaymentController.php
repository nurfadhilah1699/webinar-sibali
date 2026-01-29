<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $user = Auth::user();
        
        // Simpan file ke folder storage/app/public/payments
        if ($request->hasFile('payment_proof')) {
            $path = $request->file('payment_proof')->store('payments', 'public');
            
            // PERBAIKAN DI SINI:
            // Kita update bukti bayar DAN menghapus pesan penolakan sebelumnya
            $user->update([
                'payment_proof' => $path,
                'rejection_message' => null // Ini akan membuat dashboard kembali ke status "Sedang Diperiksa"
            ]);
        }
        
        return back()->with('success', 'Bukti pembayaran berhasil diunggah! Mohon tunggu verifikasi admin.');
    }
}
