<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Team extends Model
{
    use HasFactory;

    protected $fillable = ['team_name', 'school_name', 'access_code'];

    // Relasi ke pendaftaran
    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }
}