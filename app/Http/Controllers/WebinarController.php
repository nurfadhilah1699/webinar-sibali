<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;

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
        // Logika pendaftaran akan kita buat di sini nanti
        return "Proses pendaftaran webinar...";
    }
}