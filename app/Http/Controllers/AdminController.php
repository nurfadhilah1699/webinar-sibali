<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Question;
use Illuminate\Support\Facades\Storage;
use App\Models\Content;
use App\Models\Registration;
use App\Models\Event;

class AdminController extends Controller
{
    public function index()
    {
        // 1. Ambil pendaftar dari sistem baru (Multi-Event)
        $newRegistrations = Registration::with(['user', 'event'])
            ->where('status', 'pending')
            ->whereNotNull('payment_proof')
            ->get();

        // 2. Ambil pendaftar dari sistem lama (Single Event di tabel Users)
        $legacyRegistrations = User::whereNotNull('payment_proof')
            ->where('is_verified', false)
            ->where('role', '!=', 'admin')
            ->get()
            ->map(function($user) {
                // Kita samakan strukturnya agar Blade tidak error
                return (object)[
                    'id' => $user->id,
                    'is_legacy' => true, // Penanda data lama
                    'user' => $user,
                    'event' => (object)['title' => 'Webinar Beasiswa Unlocked: Dari Mimpi Ke Kampus Impian'], 
                    'package_type' => $user->package ?? 'reguler' ,
                    'amount' => match($user->package) {
                        'reguler' => 20000,
                        'vip1'    => 50000,
                        'vip2'    => 100000,
                        default   => 20000,
                    }, // Contoh harga lama
                    'payment_proof' => $user->payment_proof,
                    'created_at' => $user->created_at
                ];
            });

        // 3. Gabungkan dan urutkan dari yang terbaru
        $pendingRegistrations = $newRegistrations->concat($legacyRegistrations)->sortByDesc('created_at');

        // Ambil status sertifikat dari database
        $isCertReady = DB::table('settings')->where('key', 'is_certificate_ready')->value('value') == '1';
        $isTestOpen = DB::table('settings')->where('key', 'is_test_open')->value('value') == '1';
        $totalEvents = Event::count();
        $totalParticipants = Registration::where('status', 'verified')->count();

        return view('admin.dashboard', compact('pendingRegistrations', 'isCertReady', 'isTestOpen', 'totalEvents', 'totalParticipants'));
    }

    // FUNGSI APPROVE UNTUK DATA LAMA (Tabel Users)
    public function approveLegacy($id)
    {
        $user = User::findOrFail($id);
        $user->update([
            'is_verified' => true,
            'rejection_message' => null
        ]);

        return back()->with('success', "Pembayaran {$user->name} berhasil diverifikasi (Sistem Lama).");
    }

    // FUNGSI REJECT UNTUK DATA LAMA (Tabel Users)
    public function rejectLegacy(Request $request, $id)
    {
        $request->validate(['reason' => 'required|string|max:255']);

        $user = User::findOrFail($id);
        
        // Hapus file lama jika ada
        if ($user->payment_proof) {
            \Storage::disk('public')->delete($user->payment_proof);
        }

        $user->update([
            'payment_proof' => null,
            'is_verified' => false,
            'rejection_message' => $request->reason
        ]);

        return back()->with('success', "Pembayaran {$user->name} ditolak (Sistem Lama).");
    }
    public function storeEvent(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:webinar,lcc',
            'start_time' => 'required|date',
            // Tambahkan validasi lain sesuai kebutuhan
        ]);

        $slug = \Str::slug($request->title) . '-' . rand(100, 999);

        Event::create([
            'title' => $request->title,
            'slug' => $slug,
            'type' => $request->type,
            'start_time' => $request->start_time,
            'is_active' => true,
        ]);

        return redirect()->back()->with('success', 'Event baru berhasil diterbitkan!');
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

    public function verified($id)
    {
        // 1. Cari data pendaftaran (Registration), bukan User langsung
        $registration = Registration::with('user', 'event')->findOrFail($id);
        
        // 2. Update status pendaftaran menjadi verified
        $registration->update(['status' => 'verified']);

        // 3. Ambil data user dari relasi pendaftaran tersebut
        $user = $registration->user;

        // (Opsional) Jika is_verified di tabel User masih dipakai untuk login/akses
        $user->update(['is_verified' => true]);

        try {
            // Tambahkan nama event agar email lebih jelas
            $eventName = $registration->event->title ?? 'Event';
            
            \Mail::raw("Halo {$user->name}, Pembayaran Anda untuk {$eventName} telah diverifikasi. Sekarang Anda dapat mengakses link Zoom dan materi di Dashboard.", function ($message) use ($user) {
                $message->to($user->email)
                        ->from(config('mail.from.address'), config('mail.from.name'))
                        ->subject('Pembayaran Terverifikasi - Sibali.id');
            });
        } catch (\Exception $e) {
            // Abaikan error email
        }

        return back()->with('status', 'Pendaftaran ' . $user->name . ' berhasil diverifikasi!');
    }

    public function reject(Request $request, $id)
    {
        $request->validate([
            'reason' => 'required|string|max:255'
        ]);

        // 1. Cari data pendaftaran
        $registration = Registration::with('user')->findOrFail($id);
        $user = $registration->user;
        
        // 2. Hapus bukti pembayaran pendaftaran ini
        if ($registration->payment_proof) {
            \Storage::disk('public')->delete($registration->payment_proof);
        }

        // 3. Update status pendaftaran dan simpan alasan di tabel registrations
        $registration->update([
            'payment_proof' => null,
            'status' => 'rejected',
            'rejection_message' => $request->reason // Pastikan kolom ini ada di tabel registrations
        ]);

        return back()->with('status', 'Pembayaran pendaftaran ' . $user->name . ' ditolak.');
    }

    public function participants(Request $request) 
    {
        $eventId = $request->query('event_id');
        $events = Event::all();
        $search = $request->query('search');
        $status = $request->query('status'); 
        

        // 1. Ambil Data dari Tabel Registrations (Sistem Baru)
        $newParticipants = Registration::with(['user', 'event'])
            ->when($search, function($q) use ($search) {
                $q->whereHas('user', function($u) use ($search) {
                    $u->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->when($status, function($q) use ($status) {
                // Sesuaikan status database dengan filter UI
                if($status === 'approved') return $q->whereIn('status', ['verified', 'approved']);
                return $q->where('status', $status);
            })
            ->when($eventId, fn($q) => $q->where('event_id', $eventId))
            ->get()
            ->map(fn($reg) => (object)[
                'name' => $reg->user->name,
                'email' => $reg->user->email,
                'phone' => $reg->user->phone,
                'package' => $reg->package_type,
                'event_title' => $reg->event->title,
                'toefl_score' => $reg->user->toefl_score,
                // Standarisasi status
                'status_label' => match($reg->status) {
                    'verified', 'approved' => 'approved',
                    'rejected' => 'rejected',
                    default => 'pending',
                },
                'created_at' => $reg->created_at,
                'payment_proof' => $reg->payment_proof
            ]);

        // 2. Ambil Data dari Tabel Users (Sistem Legacy)
        $legacyParticipants = collect();
        if (!$eventId) {
            $legacyParticipants = User::where('role', 'user')
                ->whereNotNull('package')
                ->when($search, function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
                })
                ->when($status, function($q) use ($status) {
                    if($status === 'approved') return $q->where('is_verified', true);
                    if($status === 'rejected') return $q->whereNotNull('rejection_message')->where('is_verified', false);
                    if($status === 'pending') return $q->whereNull('rejection_message')->where('is_verified', false);
                })
                ->get()
                ->map(fn($u) => (object)[
                    'name' => $u->name,
                    'email' => $u->email,
                    'phone' => $u->phone,
                    'package' => $u->package ?? 'reguler',
                    'event_title' => 'Webinar Beasiswa Unlocked: Dari Mimpi Ke Kampus Impian',
                    'toefl_score' => $u->toefl_score,
                    // Logika Rejected untuk sistem lama: Tidak verif tapi ada pesan penolakan
                    'status_label' => $u->is_verified ? 'approved' : (!empty($u->rejection_message) ? 'rejected' : 'pending'),
                    'created_at' => $u->created_at,
                    'payment_proof' => $u->payment_proof
                ]);
        }

        $users = $newParticipants->concat($legacyParticipants)->sortByDesc('created_at');

        return view('admin.participants', compact('users', 'events'));
    }

    public function exportExcel(Request $request) 
    {
        $fileName = 'daftar_peserta_' . date('Y-m-d') . '.csv';
        
        // Gunakan logika yang sama dengan index participants untuk mengambil data
        $newRegs = Registration::with(['user', 'event'])->where('status', 'verified')->get();
        $legacyUsers = User::where('role', 'user')->where('is_verified', true)->whereDoesntHave('registrations')->get();

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['Nama', 'Email', 'No Telp', 'Event', 'Paket', 'Skor TOEFL', 'Join Date'];

        $callback = function() use($newRegs, $legacyUsers, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            // Tulis data baru
            foreach ($newRegs as $reg) {
                fputcsv($file, [$reg->user->name, $reg->user->email, $reg->user->phone, $reg->event->title, $reg->package_type, $reg->user->toefl_score ?? '0', $reg->created_at]);
            }
            // Tulis data lama
            foreach ($legacyUsers as $u) {
                fputcsv($file, [$u->name, $u->email, $u->phone, 'Webinar Legacy', $u->package, $u->toefl_score ?? '0', $u->created_at]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function materials() 
    {
        // Ambil materi beserta data event-nya untuk ditampilkan di tabel
        $contents = Content::with('event')->orderBy('created_at', 'desc')->get();
        
        // Ambil semua event untuk pilihan di dropdown form
        $events = Event::orderBy('title', 'asc')->get();
        
        return view('admin.materials', compact('contents', 'events'));
    }

    public function storeContent(Request $request) {
        $request->validate([
            'event_id' => 'required|exists:events,id', // Tambahkan validasi event_id
            'title'    => 'required',
            'type'     => 'required',
            'link'     => 'required|url',
            'package'  => 'required'
        ]);

        Content::create($request->all());
        return back()->with('status', 'Konten berhasil diterbitkan!');
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
        $data = $request->except(['audio_file', 'delete_audio']);

        // LOGIK HANDLING AUDIO
        if ($request->hasFile('audio_file')) {
            // Hapus lama, simpan baru (Logika kamu yang tadi sudah benar)
            if ($question->audio_path) {
                \Storage::disk('public')->delete($question->audio_path);
            }
            $file = $request->file('audio_file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('audios', $filename, 'public');
            $data['audio_path'] = $path;

        } elseif ($request->input('delete_audio') == '1' || $request->category !== 'listening') {
            // Hapus audio jika tombol hapus diklik ATAU kategori diganti dari listening
            if ($question->audio_path) {
                \Storage::disk('public')->delete($question->audio_path);
            }
            $data['audio_path'] = null;
        }

        $question->update($data);

        return back()->with('status', 'Soal berhasil diperbarui!');
    }
}
