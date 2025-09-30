<?php

namespace App\Models;

use Carbon\Carbon;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Accounting extends Model
{
    use HasFactory, LogsActivity;
    protected $primaryKey = "accounting_id";
    protected $table = "accounting";


    protected static $recordEvents = ['deleted', 'created', 'updated'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->setDescriptionForEvent(fn(string $eventName) => $eventName)
            ->useLogName('Journal Book');
    }

    public static function getFiscalYear()
    {

        $currentDate = Carbon::now();

        $accounting = Accounting::where(['status' => 'open'])->first();

        $year = Carbon::parse($accounting->start_date)->year;


        $accounting->default_start = Carbon::parse($currentDate->startOfMonth()->toDateString())->year($year)->format('Y-m-d');
        $accounting->default_end = Carbon::parse($currentDate->endOfMonth()->toDateString())->year($year)->format('Y-m-d');

        return $accounting;
    }

    public static function getFiscaltoday()
    {

        $currentDate = Carbon::now();

        $accounting = Accounting::where(['status' => 'open'])->first();

        // $year = Carbon::parse($accounting->start_date)->year;
        $currentYear = $currentDate->year;

        $accounting->default_start = Carbon::parse($currentDate->startOfMonth()->toDateString())->year($currentYear)->format('Y-m-d');
        $accounting->default_end = Carbon::parse($currentDate->endOfMonth()->toDateString())->year($currentYear)->format('Y-m-d');

        return $accounting;
    }


    public function createFiscalYear($start, $end, $method = 'accrual')
    {

        $accounting = new Accounting();

        $accounting->start_date = $request->start_date;
        $accounting->end_date = $request->end_date;
        $accounting->method = $request->method;
        $accounting->save();

        return $accounting;
    }

    public function checkFiscalYear($start, $end)
    {

        $accounting = Accounting::where(['start_date' => $start_date, 'end_date' => $end])->first();
    }


    public function closeAccountingPeriod() {}

    public function updateOpeningBalance() {}

    public function getAccountEndingBalance() {}

    public function openAccountingPeriod() {}
}
