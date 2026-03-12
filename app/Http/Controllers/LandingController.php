<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;

class LandingController extends Controller
{
    public function index() {
        $events = Event::orderBy('is_active', 'desc')
                    ->orderBy('start_time', 'desc')
                    ->get();

        return view('welcome', compact('events'));
    }
}
