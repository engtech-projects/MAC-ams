<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionStatus extends Model
{
    use HasFactory;

    protected $table = 'transaction_status';
    protected $primaryKey = 'transaction_status_id';
    public $timestamps = true;

    protected $fillable = [
    	'status', 'default', 'transaction_type_id'
    ];

    public static function statuses(Array $type) {
    	return TransactionStatus::select('transaction_status_id')
    			->select('status')->distinct()
    			->whereIn(
    				'transaction_type_id', 
    				$type
    			)
    			->get();
    }
}
