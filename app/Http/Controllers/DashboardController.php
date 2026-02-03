<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Content;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index() 
    {
        $user = \Auth::user();

        // Mengambil semua setting sekaligus dan menyimpannya di Cache selama 10 menit
        // Ini akan mengurangi beban database secara signifikan
        $settings = \Cache::remember('site_settings', 600, function () {
            return \DB::table('settings')->pluck('value', 'key');
        });

        $isCertReady = ($settings['is_certificate_ready'] ?? '0') === '1';
        $isTestOpen = ($settings['is_test_open'] ?? '0') === '1';

        // Ambil konten berdasarkan paket user
        $myContents = Content::whereIn('package', [$user->package, 'all'])->get();

        return view('dashboard', compact('myContents', 'isCertReady', 'isTestOpen'));
    }
}
