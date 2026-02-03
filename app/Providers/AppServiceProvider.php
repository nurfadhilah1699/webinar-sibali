<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        VerifyEmail::toMailUsing(function (object $notifiable, string $url) {
            return (new MailMessage)
                ->subject('Verifikasi Akun - Sibali.id')
                ->greeting('Halo, ' . $notifiable->name . '!')
                ->line('Terima kasih telah mendaftar di event kami.')
                ->line('Silakan klik tombol di bawah ini untuk memverifikasi alamat email Anda agar bisa melanjutkan ke proses pembayaran.')
                ->action('Verifikasi Email Sekarang', $url)
                ->line('Jika Anda tidak merasa mendaftar, abaikan email ini.')
                ->salutation('Salam hangat, Tim Sibali.');
        });
    }
}
