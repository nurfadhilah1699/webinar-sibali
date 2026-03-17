<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;

class LandingController extends Controller
{
    public function index() {
        $events = Event::whereNull('parent_id')
                    ->orderBy('is_active', 'desc')
                    ->orderBy('start_time', 'desc')
                    ->get();

        return view('welcome', compact('events'));
    }

    public function show($slug) {
        $event = Event::with('children')->where('slug', $slug)->firstOrFail();

        if ($event->type == 'webinar') {
            // Arahkan ke view khusus webinar
            return view('webinar.show', compact('event'));
        } 
        
        if ($event->type == 'lcc') {
            // Arahkan ke view khusus LCC
            return view('lcc.show', compact('event'));
        }

        // Default jika tipe tidak dikenal
        return view('pages.events.default-detail', compact('event'));
    }
}
