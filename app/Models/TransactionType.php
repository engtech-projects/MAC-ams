<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\TransactionStatus;

class TransactionType extends Model
{
    use HasFactory;

    protected $table = 'transaction_type';
    protected $primaryKey = 'transaction_type_id';
    public $timestamps = true;

    protected $fillable = [
    	'transaction_type', 'transaction_category_id', 'visible', 'account_id', 'counter_account_id'
    ];

}
