<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CertificateController extends Controller
{
    public function download()
    {
        $user = Auth::user();
        
        // 1. Cek apakah admin sudah mengaktifkan sertifikat
        $isReady = DB::table('settings')->where('key', 'is_certificate_ready')->value('value');
        if ($isReady !== '1') {
            return back()->with('error', 'Sertifikat belum tersedia. Akan aktif setelah acara selesai.');
        }

        if (!$user->is_verified) {
            return back()->with('error', 'Akun Anda belum terverifikasi.');
        }

        // 2. Siapkan data dasar
        $data = [
            'name' => strtoupper($user->name),
            'package' => strtoupper($user->package),
            'date' => date('d F Y'),
            'id_sertifikat' => 'CERT/' . $user->id . '/' . date('Ymd'),
            'score' => null // Default kosong
        ];

        // 3. Khusus VIP 2: Sertakan Skor TOEFL (Ambil dari kolom toefl_score di tabel users)
        if ($user->package === 'vip2') {
            // Asumsi kita nanti punya kolom 'toefl_score' di tabel users
            $data['score'] = $user->toefl_score ?? 'Belum Tes'; 
        }

        $pdf = Pdf::loadView('certificate.template', $data)->setPaper('a4', 'landscape');
        return $pdf->download('Sertifikat-' . $user->name . '.pdf');
    }
}
