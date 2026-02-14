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

        // Tetap pertahankan syarat ketatmu
        if ($isReady !== '1' || !$user->is_verified || $user->package !== 'vip2' || !$user->toefl_score) {
            return back()->with('error', 'Sertifikat TOEFL belum tersedia.');
        }

        $nomorUrut = str_pad($user->id, 3, '0', STR_PAD_LEFT);
        $bulanRomawi = "II"; // Karena sekarang Februari 2026
        $tahun = "2026";
        $id_sertifikat = $nomorUrut . "/TP-TOEFL/SBI/" . $bulanRomawi . "/" . $tahun;

        $data = [
            'name'          => strtoupper($user->name),
            'id_sertifikat' => $id_sertifikat,
            'listening'     => $user->score_listening ?? '0',
            'structure'     => $user->score_structure ?? '0',
            'reading'       => $user->score_reading ?? '0',
            'score'         => $user->toefl_score ?? '0',
        ];

        return Pdf::loadView('certificate.template_toefl', $data)
                    ->setPaper('a4', 'landscape')
                    ->download('TOEFL_Certificate_' . $user->name . '.pdf');
    }
}
