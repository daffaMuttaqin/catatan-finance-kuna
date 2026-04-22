<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
    protected $fillable = [
        'date',
        'name',
        'price',
        'quantity',
        'category',
        'bank_account',
        'notes',
        'created_by',
    ];
}
