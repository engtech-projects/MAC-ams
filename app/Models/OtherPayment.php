<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OtherPayment extends Model
{
    use HasFactory;

    protected $table = 'other_payments';
    protected $primaryKey = 'id';

    protected $fillable = [
        'collection_id',
        'cash_amount',
        'check_amount',
        'pos_amount',
        'memo_amount',
        'interbranch_amount',
    ];
}
