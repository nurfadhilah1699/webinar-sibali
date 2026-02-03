<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\ToeflController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'otp_verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Route untuk upload bukti pembayaran
    Route::post('/payment/upload', [PaymentController::class, 'upload'])->name('payment.upload');

    // Route untuk mengunduh sertifikat
    Route::get('/certificate/webinar', [CertificateController::class, 'downloadWebinar'])->name('certificate.webinar');
    Route::get('/certificate/toefl', [CertificateController::class, 'downloadToefl'])->name('certificate.toefl');

    // Route untuk tes TOEFL (hanya untuk VIP 2)
    // Halaman simulasi TOEFL
    Route::get('/toefl', [ToeflController::class, 'index'])->name('toefl.index');
    
    // Proses hitung skor saat klik submit
    Route::post('/toefl/submit', [ToeflController::class, 'submit'])->name('toefl.submit');
    // Hapus ini kalau sudah mau launch!
    Route::get('/dev-reset', function() {
        // Reset data di database
        Auth::user()->update([
            'toefl_score' => null, 
            'started_at' => null
        ]);

        // Beri pesan sukses pakai JavaScript agar otomatis hapus LocalStorage juga
        return "
            <script>
                localStorage.clear(); 
                alert('Database & LocalStorage berhasil dibersihkan! Silakan tes ulang.');
                window.location.href = '/dashboard';
            </script>
        ";
    });
});

// Admin routes
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::post('/admin/approve/{id}', [AdminController::class, 'approve'])->name('admin.approve');
    Route::post('/admin/reject/{id}', [AdminController::class, 'reject'])->name('admin.reject');

    // Route untuk mengaktifkan/mematikan fitur download sertifikat
    Route::post('/admin/toggle-certificate', [AdminController::class, 'toggleCertificate'])->name('admin.toggle-certificate');
    // Route untuk mengaktifkan/mematikan akses tes TOEFL
    Route::post('/admin/toggle-test', [AdminController::class, 'toggleTest'])->name('admin.test.toggle');

    // Route untuk mengelola bank soal TOEFL
    // Dashboard Utama Admin
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');

    // Menu-menu baru yang kita bahas
    Route::get('/admin/participants', [AdminController::class, 'participants'])->name('admin.participants');

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
