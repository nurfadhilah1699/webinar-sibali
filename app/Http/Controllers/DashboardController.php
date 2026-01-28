<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Content;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // Ambil data konten
        $myContents = Content::whereIn('package', [Auth::user()->package, 'all'])->get();

        // Tampilkan ke view dashboard
        return view('dashboard', compact('myContents'));
    }
}
