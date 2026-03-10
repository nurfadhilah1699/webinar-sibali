<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;

class LccController extends Controller
{
    public function index()
    {
        $lcc = Event::where('type', 'lcc')->first();
        return view('lcc.index', compact('lcc'));
    }

    public function exam()
    {
        // Logika Whitelist LCC (SIB-16) akan ada di sini
        return view('lcc.exam');
    }
}