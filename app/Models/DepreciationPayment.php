<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepreciationPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'amount',
        'sub_id',
        'date_paid',
        'created_at',
        'updated_at',
    ];

    
}