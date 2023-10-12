<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Accounting extends Model
{
    use HasFactory;
	protected $primaryKey = "accounting_id";
	protected $table = "accounting";


	public static function getFiscalYear() {
		return Accounting::find(1);
	}
}
