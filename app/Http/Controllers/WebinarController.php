<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Registration;

class WebinarController extends Controller
{
    public function index()
    {
        // Menampilkan daftar webinar yang aktif
        $events = Event::where('type', 'webinar')->where('is_active', true)->get();
        return view('webinar.index', compact('events'));
    }

    public function register(Request $request) 
    {
        $request->validate([
            'event_id' => 'required',
            'package_type' => 'required|in:full,basic,premium',
            'total_price' => 'required|numeric',
        ]);

        // Decode episodes dari JSON string
        $episodes = json_decode($request->episodes);

        $registration = Registration::create([
            'user_id' => auth()->id(),
            'event_id' => $request->event_id,
            'package_type' => $request->package_type,
            'details' => $episodes, // Simpan array langsung (karena sudah ada casting di model)
            'amount' => $request->total_price,
            'status' => 'pending', // Sesuai default di migration
        ]);

        return redirect()->route('payment.index', $registration->id)
                        ->with('success', 'Silakan selesaikan pembayaran!');
    }
}