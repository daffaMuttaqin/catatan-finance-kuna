<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $fillable = [
        'user_id',
        'action',
        'module',
        'detail',
    ];

    public $timestamps = false; // karena kita pakai created_at manual
}
