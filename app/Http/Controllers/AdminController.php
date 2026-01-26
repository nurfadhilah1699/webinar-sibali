<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index()
    {
        $pendingUsers = User::whereNotNull('payment_proof')
                            ->where('is_verified', false)
                            ->get();

        // Ambil status sertifikat dari database
        $isCertReady = DB::table('settings')->where('key', 'is_certificate_ready')->value('value') == '1';

        return view('admin.dashboard', compact('pendingUsers', 'isCertReady'));
    }

    public function toggleCertificate()
    {
        $currentStatus = DB::table('settings')->where('key', 'is_certificate_ready')->value('value');
        $newStatus = ($currentStatus == '1') ? '0' : '1';

        DB::table('settings')->where('key', 'is_certificate_ready')->update(['value' => $newStatus]);

        $pesan = ($newStatus == '1') ? 'Sertifikat sekarang bisa didownload oleh user!' : 'Akses download sertifikat ditutup.';
        
        return back()->with('status', $pesan);
    }

    public function approve($id)
    {
        $user = User::findOrFail($id);
        $user->update(['is_verified' => true]);

        return back()->with('status', 'User ' . $user->name . ' berhasil diverifikasi!');
    }

    public function reject(Request $request, $id)
    {
        $request->validate([
            'reason' => 'required|string|max:255'
        ]);

        $user = User::findOrFail($id);
        
        // Hapus foto lama agar storage tidak penuh (opsional)
        if ($user->payment_proof) {
            \Storage::disk('public')->delete($user->payment_proof);
        }

        $user->update([
            'payment_proof' => null, // User disuruh upload ulang
            'is_verified' => false,
            'rejection_message' => $request->reason
        ]);

        return back()->with('status', 'Pembayaran user ' . $user->name . ' ditolak.');
    }
}
