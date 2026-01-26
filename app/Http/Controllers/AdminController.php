<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        // Ambil user yang sudah upload bukti bayar tapi belum diverifikasi
        $pendingUsers = User::whereNotNull('payment_proof')
                            ->where('is_verified', false)
                            ->get();

        return view('admin.dashboard', compact('pendingUsers'));
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
