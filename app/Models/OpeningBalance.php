<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OpeningBalance extends Model
{
    use HasFactory;

    protected $table = 'opening_balance';
	protected $primaryKey = 'opening_balance_id';
    public $timestamps = true;

    protected $fillable = [
		'opening_balance',
		'starting_date',
		'account_id',
		'accounting_id'
    ];


    public static function balance($account_id) {

    	return OpeningBalance::where(['account_id' => $account_id])->get();

    }
}
