<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Event;
use Illuminate\Support\Str;
use Carbon\Carbon;

class MultiEventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Buat Parent (Induk Webinar Series)
        $parent = Event::create([
            'title'      => 'Cakap Digital, Tangkas Berkarir',
            'slug'       => Str::slug('Cakap Digital Tangkas Berkarir'),
            'type'       => 'webinar',
            'parent_id'  => null,
            'start_time' => Carbon::parse('2026-04-18 08:30:00'), // Ambil tgl episode pertama
            'duration'   => 275, // Contoh 275 menit
            'is_active'  => true,
        ]);

        // 2. Data Episode (Children)
        $episodes = [
            [
                'title'      => 'Episode 1: Career Preparation for Freshgraduate & Workplace Culture (Startup vs Konvensional)',
                'start_time' => '2026-04-18 08:30:00',
            ],
            [
                'title'      => 'Episode 2: Human Resources (Recruitment & Payroll)',
                'start_time' => '2026-04-19 08:30:00',
            ],
            [
                'title'      => 'Episode 3: Operation (Business Operation Associate & Project Manager)',
                'start_time' => '2026-04-24 08:30:00',
            ],
            [
                'title'      => 'Episode 4: Marketing (Marketing Communication Staff & Digital Marketing Specialist)',
                'start_time' => '2026-04-25 08:30:00',
            ],
            [
                'title'      => 'Episode 5: Finance (Financial Planner & Financial Reporting Associate)',
                'start_time' => '2026-04-26 08:30:00',
            ],
        ];

        // 3. Looping untuk masukkan ke Database
        foreach ($episodes as $ep) {
            Event::create([
                'title'      => $ep['title'],
                'slug'       => Str::slug($ep['title']),
                'type'       => 'webinar',
                'parent_id'  => $parent->id, // Menghubungkan ke ID Parent di atas
                'start_time' => Carbon::parse($ep['start_time']),
                'duration'   => 275, // Misal tiap episode 90 menit
                'is_active'  => true,
            ]);
        }

        // Contoh LCC Online
        Event::create([
            'title' => 'S-FEST (Sibali Science & Future Festival)',
            'slug' => Str::slug('S-FEST (Sibali Science & Future Festival)'),
            'type' => 'lcc',
            'start_time' => '2026-05-17 09:00:00',
            'duration' => 360,
            'is_active' => true,
        ]);

        Event::create([
            'title' => 'Webinar Beasiswa Unlocked: Road to LPDP',
            'slug' => Str::slug('Webinar Beasiswa Unlocked: Road to LPDP'),
            'type' => 'webinar',
            'start_time' => '2026-02-15 09:00:00', // Sesuaikan dengan tanggal aslinya
            'duration' => 270,
            'is_active' => false,
        ]);
    }
}
