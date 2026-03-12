<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Event;

class MultiEventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Contoh Webinar Karir Ep 1
        Event::create([
            'title' => 'Webinar Karir Episode 1: Personal Branding',
            'slug' => 'webinar-karir-1',
            'type' => 'webinar',
            'start_time' => '2026-04-01 09:00:00',
        ]);

        // Contoh LCC Online
        Event::create([
            'title' => 'Lomba Cerdas Cermat Online 2026',
            'slug' => 'lcc-2026',
            'type' => 'lcc',
            'start_time' => '2026-04-15 08:00:00',
            'duration' => 45,
        ]);

        Event::create([
            'title' => 'Webinar Beasiswa Unlocked: Road to LPDP',
            'slug' => 'webinar-beasiswa-unlocked-road-to-lpdp',
            'type' => 'webinar',
            'start_time' => '2026-02-15 09:00:00', // Sesuaikan dengan tanggal aslinya
        ]);
    }
}
