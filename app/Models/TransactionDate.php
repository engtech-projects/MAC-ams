<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionDate extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $table = 'end_transaction';
    protected $connection = 'mysql2';

    public static function get_date() {
    	return TransactionDate::where(['status' => 'open', 'branch_id' => 1])->get()->first()->date_end;
    }

}
