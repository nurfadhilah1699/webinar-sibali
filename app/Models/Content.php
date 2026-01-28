<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    protected $fillable = [
        'title',
        'type', // e.g., 'material', 'recording'
        'link',
        'package', // e.g., 'regular', 'vip1', 'vip2'
    ];
}
