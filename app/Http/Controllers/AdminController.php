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
}
