<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Content;
use App\Models\Registration;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index() 
    {
        $user = Auth::user();

        // 2. Ambil Semua Pendaftaran User (Approved & Pending)
        // Kita eager load 'event' dan 'team' untuk keperluan di Blade
        $myRegistrations = Registration::with('event')
                        ->where('user_id', $user->id)
                        ->latest()
                        ->get();

        $approvedRegistrations = $myRegistrations->where('status', 'approved');

        $hasLegacyData = !empty($user->payment_proof) || $user->is_verified;


        // 5. Daftar Event yang Tersedia (untuk ditawarkan di dashboard jika belum daftar)
        $availableEvents = Event::active()
                        ->whereNotIn('id', $myRegistrations->pluck('event_id'))
                        ->where('parent_id', null)
                        ->where('id', '!=', 22) // ID 22 anggap saja event lama
                        ->get();

        return view('dashboard', [
            'myRegistrations' => $myRegistrations,
            'approvedRegistrations' => $approvedRegistrations,
            'hasLegacyData' => $hasLegacyData,
            'availableEvents' => $availableEvents,
            'user' => $user
        ]);
    }

    public function showMyEvent($id)
    {
        // Cari pendaftaran berdasarkan ID dan pastikan milik user yang login
        $registration = Registration::with('event')->where('user_id', Auth::id())->findOrFail($id);
        
        // Ambil konten/materi jika statusnya sudah approved
        $contents = [];
        if($registration->status === 'approved') {
            // Logika ambil materi seperti di project lamamu
            $contents = Content::whereIn('package', [$registration->package_type, 'all'])->get();
        }

        return view('event-detail', compact('registration', 'contents'));
    }

    // Pastikan tidak ada ($id) di dalam kurung
    public function showLegacyEvent() 
    {
        $user = Auth::user();

        $settings = Cache::remember('site_settings', 600, function () {
            return DB::table('settings')->pluck('value', 'key');
        });

        $isCertReady = ($settings['is_certificate_ready'] ?? '0') === '1';
        $isTestOpen = ($settings['is_test_open'] ?? '0') === '1';
        
        // Logika ambil materi beasiswa lama
        $contents = Content::whereIn('package', [$user->package, 'all'])->get();

        return view('legacy-event-detail', compact('user', 'contents', 'isCertReady', 'isTestOpen'));
    }
}