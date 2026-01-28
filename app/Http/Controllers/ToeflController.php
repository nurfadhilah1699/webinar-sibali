<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Question;
use Illuminate\Support\Facades\Auth;

class ToeflController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // 1. Proteksi Akses (VIP 2 & Verifikasi)
        if ($user->package !== 'vip2' || !$user->is_verified) {
            return redirect('/dashboard')->with('error', 'Akses khusus VIP 2 yang sudah terverifikasi.');
        }

        // 2. Proteksi 1x Tes (Jika sudah ada skor, tidak boleh masuk lagi). Aktifkan saat mau deploy
        if ($user->toefl_score !== null) {
            return redirect('/dashboard')->with('error', 'Anda sudah menyelesaikan tes ini.');
        } 

        // 3. Logika Persistence Timer (Catat waktu mulai jika belum ada)
        if (!$user->started_at) {
            // Simpan waktu sekarang sebagai awal mulai tes
            $user->update([
                'started_at' => now()
            ]);
        }

        $questions = Question::orderBy('category', 'asc')->get();
        
        return view('toefl.index', compact('questions', 'user'));
    }

    public function submit(Request $request)
    {

        $userAnswers = $request->input('answers');

        if (!$userAnswers) {
            return back()->with('error', 'Kamu belum menjawab soal apapun.');
        }

        $correctListening = 0;
        $correctStructure = 0;
        $correctReading = 0;

        foreach ($userAnswers as $questionId => $answer) {
            $question = Question::find($questionId);
            
            if ($question && $question->correct_answer === $answer) {
                if ($question->category == 'listening') $correctListening++;
                elseif ($question->category == 'structure') $correctStructure++;
                elseif ($question->category == 'reading') $correctReading++;
            }
        }

        // Memanggil fungsi konversi yang ada di bawah
        $scoreL = $this->convertListening($correctListening);
        $scoreS = $this->convertStructure($correctStructure);
        $scoreR = $this->convertReading($correctReading);
        
        $finalScore = round((($scoreL + $scoreS + $scoreR) * 10) / 3);

        $user = User::find(Auth::id());
        $user->toefl_score = $finalScore;
        $user->save();

        return redirect()->route('dashboard')->with('status', 'Tes Selesai! Skor TOEFL Anda: ' . $finalScore);
    }

    // --- FUNGSI KONVERSI (WAJIB ADA DI DALAM CLASS) ---

    private function convertListening($correct) {
        // Tabel konversi sederhana (Skala 31-68)
        if ($correct >= 45) return 68;
        if ($correct >= 30) return 51;
        if ($correct >= 15) return 41;
        return 31; 
    }

    private function convertStructure($correct) {
        if ($correct >= 38) return 68;
        if ($correct >= 25) return 52;
        if ($correct >= 15) return 40;
        return 31;
    }

    private function convertReading($correct) {
        if ($correct >= 48) return 67;
        if ($correct >= 35) return 52;
        if ($correct >= 20) return 41;
        return 31;
    }
}