<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $fillable = [
        'date',
        'name',
        'size',
        'category',
        'price',
        'bank_account',
        'notes',
        'created_by',
    ];
}
