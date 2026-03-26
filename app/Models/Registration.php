<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    protected $fillable = [
        'user_id',
        'event_id',
        'team_id', 
        'package_type',
        'details',
        'amount',
        'status',
        'rejection_message',
        'payment_proof'
    ];

    // Otomatis ubah JSON ke Array saat dipanggil
    protected $casts = [
        'details' => 'array',
    ];

    public function event() {
        return $this->belongsTo(Event::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function team() {
        return $this->belongsTo(Team::class);
    }
}
