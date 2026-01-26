<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class CertificateController extends Controller
{
    public function download()
    {
        $user = Auth::user();

        // Cek apakah user sudah diverifikasi
        if (!$user->is_verified) {
            return back()->with('error', 'Sertifikat hanya tersedia untuk peserta yang sudah terverifikasi.');
        }

        // Data yang akan dikirim ke tampilan sertifikat
        $data = [
            'name' => strtoupper($user->name),
            'package' => strtoupper($user->package),
            'date' => date('d F Y'),
            'id_sertifikat' => 'CERT/' . $user->id . '/' . date('Ymd')
        ];

        // Load view dan download PDF
        $pdf = Pdf::loadView('certificate.template', $data)->setPaper('a4', 'landscape');
        return $pdf->download('Sertifikat-Webinar-' . $user->name . '.pdf');
    }
}
