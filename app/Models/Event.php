<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 
        'slug', 
        'type', 
        'parent_id', 
        'start_time', 
        'duration', 
        'is_active'
    ];

    // Casting agar start_time otomatis jadi objek Carbon (mudah diformat tgl/jam-nya)
    protected $casts = [
        'start_time' => 'datetime',
        'is_active' => 'boolean',
    ];

    /**
     * Relasi ke Pendaftaran
     */
    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }

    /**
     * Relasi untuk Series (Parent-Child)
     * Contoh: "Webinar Karir 2026" (Parent) punya banyak "Episode 1", "Episode 2" (Children)
     */
    
    // Mengambil parent dari suatu episode
    public function parent()
    {
        return $this->belongsTo(Event::class, 'parent_id');
    }

    // Mengambil semua episode/anak dari suatu series
    public function children()
    {
        return $this->hasMany(Event::class, 'parent_id');
    }

    /**
     * Scope untuk mempermudah filter event yang aktif
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}