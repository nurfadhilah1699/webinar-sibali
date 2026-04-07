<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\ToeflController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\WebinarController;
use App\Http\Controllers\LccController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\RegistrationController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Response;

Route::get('/', [LandingController::class, 'index'])->name('welcome');
Route::get('/event/{slug}', [LandingController::class, 'show'])->name('events.show');

// Route::get('/dashboard', [DashboardController::class, 'index'])
//     ->middleware(['auth', 'otp_verified'])
//     ->name('dashboard');

Route::middleware(['auth', 'otp_verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    // Route baru untuk detail event yang didaftar
});

Route::middleware('auth')->group(function () {
    Route::get('/storage/{filename}', function ($filename) {
        $path = storage_path('app/public/' . $filename);

        if (!file_exists($path)) {
            abort(404);
        }

        $file = file_get_contents($path);
        $type = mime_content_type($path);

        return Response::make($file, 200)->header("Content-Type", $type);
    })->where('filename', '.*');

    // Untuk Update Database (WAJIB JALANKAN INI) dan comment route ini lagi setelah selesai update!
    Route::get('/gas-update-db', function () {
        try {
            // 1. Jalankan Migrasi (Hanya tambah tabel/kolom baru)
            Artisan::call('migrate', ['--force' => true]);
            $migrateOutput = Artisan::output();

            // 2. Jalankan Seeder Spesifik (Ganti 'NamaSeederKamu' sesuai file seeder-mu)
            // Jika ingin menjalankan semua seeder, hapus ['--class' => ...]
            Artisan::call('db:seed', [
                '--class' => 'MultiEventSeeder', // Ganti dengan nama seeder yang ingin dijalankan
                '--force' => true
            ]);
            $seedOutput = Artisan::output();

            return "
                <h1>Database Berhasil Diupdate!</h1>
                <p><b>Hasil Migrate:</b></p>
                <pre>$migrateOutput</pre>
                <p><b>Hasil Seeder:</b></p>
                <pre>$seedOutput</pre>
            ";

        } catch (\Exception $e) {
            return " Gagal Update: " . $e->getMessage();
        }
    });

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Route untuk upload bukti pembayaran
    // Route::post('/payment/upload', [PaymentController::class, 'upload'])->name('payment.upload');

    // Route untuk mengunduh sertifikat
    Route::get('/certificate/webinar', [CertificateController::class, 'downloadWebinar'])->name('certificate.webinar');
    Route::get('/certificate/toefl', [CertificateController::class, 'downloadToefl'])->name('certificate.toefl');

    // Route untuk tes TOEFL (hanya untuk VIP 2)
    // Halaman simulasi TOEFL
    Route::get('/toefl', [ToeflController::class, 'index'])->name('toefl.index');
    
    // Proses hitung skor saat klik submit
    Route::post('/toefl/submit', [ToeflController::class, 'submit'])->name('toefl.submit');
    // Hapus/komentari ini kalau sudah launch!
    // Route::get('/dev-reset', function() {
    //     // Reset data di database
    //     Auth::user()->update([
    //         'toefl_score' => null, 
    //         'started_at' => null
    //     ]);

    //     // Beri pesan sukses pakai JavaScript agar otomatis hapus LocalStorage juga
    //     return "
    //         <script>
    //             localStorage.clear(); 
    //             alert('Database & LocalStorage berhasil dibersihkan! Silakan tes ulang.');
    //             window.location.href = '/dashboard';
    //         </script>
    //     ";
    // });

    // ==========================================
    // SIB-12: MULTI-EVENT ROUTES GROUPING
    // ==========================================

    // Rute untuk Webinar Karir (Series)
    Route::prefix('webinar-karir')->name('webinar.')->group(function () {
        Route::get('/', [WebinarController::class, 'index'])->name('index'); 
    });

    // Rute untuk LCC (Lomba Cerdas Cermat)
    Route::prefix('lcc')->name('lcc.')->group(function () {
        Route::get('/', [LccController::class, 'index'])->name('index');
        Route::get('/exam', [LccController::class, 'exam'])->name('exam');
        Route::post('/submit', [LccController::class, 'submit'])->name('submit');
    });

    // ==========================================

    Route::get('/event/{slug}/register', [RegistrationController::class, 'showRegistrationForm'])->name('event.registration.form');
    Route::post('/register-event', [RegistrationController::class, 'register'])->name('register.post');
    Route::get('/payment/{registration}', [RegistrationController::class, 'payment'])->name('payment.index');
    Route::post('/payment/confirm/{registration}', [RegistrationController::class, 'confirmPayment'])->name('payment.confirm');

    Route::get('/my-event/{registration_id}', [DashboardController::class, 'showMyEvent'])->name('my-event.detail');
    Route::get('/legacy-event', [DashboardController::class, 'showLegacyEvent'])->name('legacy-event.detail');
});

// Admin routes
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::post('/admin/verified/{id}', [AdminController::class, 'verified'])->name('admin.verified');
    Route::post('/admin/reject/{id}', [AdminController::class, 'reject'])->name('admin.reject');

    // Route untuk Legacy (Tabel Users) - SIB-29
    Route::post('/admin/approve-legacy/{id}', [AdminController::class, 'approveLegacy'])->name('admin.approve.legacy');
    Route::post('/admin/reject-legacy/{id}', [AdminController::class, 'rejectLegacy'])->name('admin.reject.legacy');

    Route::post('/admin/events', [AdminController::class, 'storeEvent'])->name('admin.events.store');

    // Route untuk mengaktifkan/mematikan fitur download sertifikat
    Route::post('/admin/toggle-certificate', [AdminController::class, 'toggleCertificate'])->name('admin.toggle-certificate');
    // Route untuk mengaktifkan/mematikan akses tes TOEFL
    Route::post('/admin/toggle-test', [AdminController::class, 'toggleTest'])->name('admin.test.toggle');

    // Route untuk mengelola bank soal TOEFL
    // Dashboard Utama Admin
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');

    // Menu-menu baru yang kita bahas
    Route::get('/admin/participants', [AdminController::class, 'participants'])->name('admin.participants');
    Route::get('/admin/participants/export', [AdminController::class, 'exportExcel'])->name('admin.participants.export');

    // Materi & Rekaman
    Route::get('/admin/materials', [AdminController::class, 'materials'])->name('admin.materials');
    Route::post('/admin/materials', [AdminController::class, 'storeContent'])->name('admin.materials.store');
    Route::delete('/admin/materials/{id}', [AdminController::class, 'deleteContent'])->name('admin.materials.delete');
    
    // Bank Soal
    Route::get('/admin/questions', [AdminController::class, 'questions'])->name('admin.questions'); // Tampilan form
    Route::post('/admin/questions', [AdminController::class, 'storeQuestion'])->name('admin.questions.store'); // Proses simpan
    Route::delete('/admin/questions/{id}', [AdminController::class, 'deleteQuestion'])->name('admin.questions.delete');
    Route::put('/admin/questions/{id}/update', [AdminController::class, 'updateQuestion'])->name('admin.questions.update');
});

require __DIR__.'/auth.php';
