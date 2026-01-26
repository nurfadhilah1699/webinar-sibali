<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ToeflController extends Controller
{
    public function index()
    {
        // Hanya VIP 2 yang bisa akses
        if (Auth::user()->package !== 'vip2' || !Auth::user()->is_verified) {
            return redirect('/dashboard')->with('error', 'Akses khusus VIP 2.');
        }
        return view('toefl.index');
    }

    public function submit(Request $request)
    {
        // Contoh logika: 5 soal, per soal poin 100. (Total 500)
        // Di dunia nyata, TOEFL punya konversi tabel sendiri, tapi kita pakai poin simpel dulu.
        $answers = [
            'q1' => 'B',
            'q2' => 'A',
            'q3' => 'C',
            'q4' => 'D',
            'q5' => 'B',
        ];

        $score = 0;
        foreach ($answers as $question => $correctAnswer) {
            if ($request->input($question) === $correctAnswer) {
                $score += 100;
            }
        }

        // Simpan skor ke database
        $user = User::find(Auth::id());
        $user->toefl_score = $score;
        $user->save();

        return redirect()->route('dashboard')->with('status', 'Simulasi selesai! Skor kamu: ' . $score);
    }
}
