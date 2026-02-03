<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CertificateController extends Controller
{
    public function downloadWebinar()
{
    $user = Auth::user();
    $isReady = DB::table('settings')->where('key', 'is_certificate_ready')->value('value');

    if ($isReady !== '1' || !$user->is_verified) {
        return back()->with('error', 'Sertifikat belum tersedia.');
    }

    $data = [
        'name' => strtoupper($user->name),
        'package' => strtoupper($user->package),
        'id_sertifikat' => 'WEB/' . $user->id . '/' . date('Ymd'),
        'score' => null 
    ];

    // Menggunakan template khusus webinar
    return Pdf::loadView('certificate.template_webinar', $data)
              ->setPaper('a4', 'landscape')
              ->download('Sertifikat_Webinar_' . $user->name . '.pdf');
    }

    public function downloadToefl()
    {
        $user = Auth::user();
        $isReady = DB::table('settings')->where('key', 'is_certificate_ready')->value('value');

        // Syarat: Admin buka akses, User Terverifikasi, Paket VIP Plus, & Sudah ada skor
        if ($isReady !== '1' || !$user->is_verified || $user->package !== 'vip2' || !$user->toefl_score) {
            return back()->with('error', 'Sertifikat TOEFL belum tersedia.');
        }

        $data = [
            'name' => strtoupper($user->name),
            'package' => strtoupper($user->package),
            'id_sertifikat' => 'TFL/' . $user->id . '/' . date('Ymd'),
            'score' => $user->toefl_score 
        ];

        // Menggunakan template khusus toefl
        return Pdf::loadView('certificate.template_toefl', $data)
                ->setPaper('a4', 'landscape')
                ->download('Sertifikat_TOEFL_' . $user->name . '.pdf');
    }
}
