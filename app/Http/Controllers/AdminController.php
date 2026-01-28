<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Question;
use Illuminate\Support\Facades\Storage;
use App\Models\Content;

class AdminController extends Controller
{
    public function index()
    {
        $pendingUsers = User::whereNotNull('payment_proof')
                            ->where('is_verified', false)
                            ->get();

        // Ambil status sertifikat dari database
        $isCertReady = DB::table('settings')->where('key', 'is_certificate_ready')->value('value') == '1';

        return view('admin.dashboard', compact('pendingUsers', 'isCertReady'));
    }

    public function toggleCertificate()
    {
        $currentStatus = DB::table('settings')->where('key', 'is_certificate_ready')->value('value');
        $newStatus = ($currentStatus == '1') ? '0' : '1';

        DB::table('settings')->where('key', 'is_certificate_ready')->update(['value' => $newStatus]);

        $pesan = ($newStatus == '1') ? 'Sertifikat sekarang bisa didownload oleh user!' : 'Akses download sertifikat ditutup.';
        
        return back()->with('status', $pesan);
    }

    public function approve($id)
    {
        $user = User::findOrFail($id);
        $user->update(['is_verified' => true]);

        return back()->with('status', 'User ' . $user->name . ' berhasil diverifikasi!');
    }

    public function reject(Request $request, $id)
    {
        $request->validate([
            'reason' => 'required|string|max:255'
        ]);

        $user = User::findOrFail($id);
        
        // Hapus foto lama agar storage tidak penuh (opsional)
        if ($user->payment_proof) {
            \Storage::disk('public')->delete($user->payment_proof);
        }

        $user->update([
            'payment_proof' => null, // User disuruh upload ulang
            'is_verified' => false,
            'rejection_message' => $request->reason
        ]);

        return back()->with('status', 'Pembayaran user ' . $user->name . ' ditolak.');
    }

    public function participants() {
        $users = User::where('role', 'user')->get();
        return view('admin.participants', compact('users'));
    }

    public function materials() {
        $contents = Content::orderBy('type', 'asc')->get();
        return view('admin.materials', compact('contents'));
    }

    public function storeContent(Request $request) {
        $request->validate([
            'title' => 'required',
            'type' => 'required',
            'link' => 'required|url',
            'package' => 'required'
        ]);

        Content::create($request->all());

        return back()->with('status', 'Konten berhasil ditambahkan!');
    }

    public function deleteContent($id) {
        Content::destroy($id);
        return back()->with('status', 'Konten berhasil dihapus!');
    }

    public function questions() {
        // Nanti kita buat CRUD Soal di sini
        return view('admin.questions');
    }

    public function storeQuestion(Request $request) {
        $request->validate([
            'category' => 'required',
            'question_text' => 'required',
            'audio_file' => 'nullable|mimes:mp3,wav,ogg|max:20000', // max 20MB
        ]);

        $pathForDb = null; // Kita siapkan variabel penampung

        if ($request->hasFile('audio_file')) {
            // Simpan file ke storage/app/public/audios
            $file = $request->file('audio_file');
            $filename = time() . '_' . $file->getClientOriginalName();
            
            // Simpan file dan ambil path-nya
            $file->storeAs('audios', $filename, 'public');
            
            // Isi variabel untuk disimpan ke database
            $pathForDb = 'audios/' . $filename;
        }

        // SIMPAN KE DATABASE
        Question::create([
            'category' => $request->category,
            'question_text' => $request->question_text,
            'audio_path' => $pathForDb, // Pastikan ini sama dengan nama kolom di migration
            'option_a' => $request->option_a,
            'option_b' => $request->option_b,
            'option_c' => $request->option_c,
            'option_d' => $request->option_d,
            'correct_answer' => $request->correct_answer,
        ]);

        return back()->with('status', 'Soal berhasil disimpan dengan audio!');
    }
}
