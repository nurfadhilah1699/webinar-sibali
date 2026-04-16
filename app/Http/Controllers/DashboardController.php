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
        $myRegistrations = Registration::with('event.parent')
                        ->where('user_id', $user->id)
                        ->latest()
                        ->get();

        $approvedRegistrations = $myRegistrations->where('status', 'approved');

        $hasLegacyData = !empty($user->payment_proof) || !empty($user->package);


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
        // Eager load event dan children-nya
        $registration = Registration::with(['event.children'])->where('user_id', Auth::id())->findOrFail($id);
        
        $contents = [];
        
        // Syarat akses: status harus verified (atau approved sesuai standarisasimu)
        if(in_array($registration->status, ['verified', 'approved'])) {
            
            if ($registration->package_type === 'full' || $registration->package_type === 'premium') {
                // Jika PAKET FULL: Ambil semua konten milik Parent DAN semua Anak (Episode) dibawahnya
                $childIds = $registration->event->children->pluck('id');
                $contents = Content::whereIn('event_id', $childIds)
                            ->orWhere('event_id', $registration->event_id)
                            ->get();
            } else {
                // Jika PAKET BASIC/LCC: Hanya ambil konten yang event_id-nya cocok dengan pendaftaran
                $contents = Content::where('event_id', $registration->event_id)->get();
            }
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