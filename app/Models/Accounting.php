<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Accounting extends Model
{
    use HasFactory;
	protected $primaryKey = "accounting_id";
	protected $table = "accounting";


	public static function getFiscalYear() {

		$currentDate = Carbon::now();

		$accounting = Accounting::where(['status' => 'open' ])->first();

		$year = Carbon::parse($accounting->start_date)->year;

		$accounting->default_start = Carbon::parse($currentDate->startOfMonth()->toDateString())->year($year)->format('Y-m-d');
		$accounting->default_end = Carbon::parse($currentDate->endOfMonth()->toDateString())->year($year)->format('Y-m-d');

		return $accounting;
	}

}
