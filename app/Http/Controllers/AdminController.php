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

        // Ambil status pembukaan tes dari database
        $isTestOpen = DB::table('settings')->where('key', 'is_test_open')->value('value') == '1';

        return view('admin.dashboard', compact('pendingUsers', 'isCertReady', 'isTestOpen'));
    }

    public function toggleCertificate()
    {
        // 1. Ambil status sekarang
        $currentStatus = DB::table('settings')->where('key', 'is_certificate_ready')->value('value');
        
        // 2. Balik statusnya
        $newStatus = ($currentStatus == '1') ? '0' : '1';

        // 3. Update ke Database
        DB::table('settings')->where('key', 'is_certificate_ready')->update(['value' => $newStatus]);

        // 4. PENTING: Hapus cache agar Dashboard User langsung "sadar" ada perubahan
        \Cache::forget('site_settings');

        $pesan = ($newStatus == '1') ? 'Sertifikat AKTIF & bisa didownload!' : 'Akses sertifikat DITUTUP.';
        return back()->with('status', $pesan);
    }

    public function toggleTest()
    {
        $currentStatus = DB::table('settings')->where('key', 'is_test_open')->value('value');
        $newStatus = ($currentStatus == '1') ? '0' : '1';

        DB::table('settings')->where('key', 'is_test_open')->update(['value' => $newStatus]);

        // Hapus cache juga untuk status ujian
        \Cache::forget('site_settings');

        $pesan = ($newStatus == '1') ? 'Ujian TOEFL DIBUKA!' : 'Ujian TOEFL DITUTUP.';
        return back()->with('status', $pesan);
    }

    public function approve($id)
    {
        $user = User::findOrFail($id);
        $user->update(['is_verified' => true]);

        // Tambahkan notifikasi email otomatis
        try {
            \Mail::raw("Halo {$user->name}, Pembayaran Anda telah diverifikasi oleh Admin. Sekarang Anda dapat mengakses link Zoom dan Sertifikat di Dashboard.", function ($message) use ($user) {
                $message->to($user->email)
                        ->from(config('mail.from.address'), config('mail.from.name')) // TAMBAHKAN INI
                        ->subject('Pembayaran Terverifikasi - Sibali.id');
            });
        } catch (\Exception $e) {
            // Abaikan jika gagal kirim email agar proses approve tidak terhenti
        }

        return back()->with('status', 'User ' . $user->name . ' berhasil diverifikasi dan email notifikasi terkirim!');
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

    public function participants(Request $request) {
        // Ambil input filter dari URL (jika ada)
        $packageFilter = $request->query('package');

        $query = User::where('role', 'user');

        // Jika filter dipilih, saring datanya
        if ($packageFilter) {
            $query->where('package', $packageFilter);
        }

        $users = $query->latest()->get();

        return view('admin.participants', compact('users'));
    }

    // FUNGSI EXCEL (CSV)
    public function exportExcel() {
        $fileName = 'daftar_peserta_' . date('Y-m-d') . '.csv';
        $users = User::where('role', 'user')->get();

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['Nama', 'Email', 'No Telp', 'Paket','Pembayaran', 'Skor TOEFL', 'Status'];

        $callback = function() use($users, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($users as $user) {
                fputcsv($file, [
                    $user->name,
                    $user->email,
                    $user->phone,
                    $user->package,
                    $user->payment_proof,
                    $user->toefl_score ?? 'N/A',
                    $user->is_verified ? 'Verified' : 'Pending'
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
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

    public function questions(Request $request) {
        $query = Question::query();

        // Pastikan menggunakan 'category' sesuai dengan <select name="category">
        if ($request->has('category') && $request->category != '') {
            $query->where('category', $request->category);
        }

        $questions = $query->latest()->paginate(10);

        // Hitung statistik (tetap tampilkan total semua soal)
        $counts = [
            'listening' => Question::where('category', 'listening')->count(),
            'structure' => Question::where('category', 'structure')->count(),
            'reading'   => Question::where('category', 'reading')->count(),
        ];

        return view('admin.questions', compact('counts', 'questions'));
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

    public function deleteQuestion($id)
    {
        $question = Question::findOrFail($id);

        // Hapus file audio dari storage jika ada agar tidak jadi sampah
        if ($question->audio_path) {
            \Storage::disk('public')->delete($question->audio_path);
        }

        $question->delete();

        return back()->with('status', 'Soal berhasil dihapus dari database!');
    }

    public function updateQuestion(Request $request, $id)
    {
        $request->validate([
            'category' => 'required',
            'question_text' => 'required',
            'audio_file' => 'nullable|mimes:mp3,wav,ogg|max:20000',
        ]);

        $question = Question::findOrFail($id);
        
        $data = $request->only(['category', 'question_text', 'option_a', 'option_b', 'option_c', 'option_d', 'correct_answer']);

        if ($request->hasFile('audio_file')) {
            // Hapus audio lama jika ada audio baru
            if ($question->audio_path) {
                \Storage::disk('public')->delete($question->audio_path);
            }
            $file = $request->file('audio_file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('audios', $filename, 'public');
            $data['audio_path'] = 'audios/' . $filename;
        }

        $question->update($data);

        return back()->with('status', 'Soal berhasil diperbarui!');
    }
}
