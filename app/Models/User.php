<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'address',
        'user_category',
        'institution',
        'package',
        'payment_proof',
        'is_verified',
        'rejection_message',
        'toefl_score',
        'score_listening',
        'score_structure',
        'score_reading',
        'started_at',
        'otp_code',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Tambahkan di dalam class User di User.php
    public function getPackageNameAttribute()
    {
        return [
            'reguler' => 'Reguler',
            'vip1'    => 'VIP',
            'vip2'    => 'VIP Plus+',
        ][$this->package] ?? ucfirst($this->package);
    }
}
