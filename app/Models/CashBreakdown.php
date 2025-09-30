<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CashBreakdown extends Model
{
    use HasFactory;

    protected $table = 'cash_breakdown';
    protected $primaryKey = 'cbreakdown_id';

    protected $fillable = [
        'onethousand_pesos',
        'fivehundred_pesos',
        'twohundred_pesos',
        'onehundred_pesos',
        'fifty_pesos',
        'twenty_pesos',
        'ten_pesos',
        'five_pesos',
        'one_peso',
        'one_centavo',
        'total_amount',
        'cashblotter_id'
    ];
    protected $casts = [
        'created_at'  => 'date:Y-m-d',

    ];
    protected static $recordEvents = ['deleted', 'created', 'updated'];

    public function getModelName()
    {

        return class_basename($this);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->setDescriptionForEvent(fn(string $eventName) => $eventName)
            ->useLogName('Cash Transaction Blotter - Cash Breakdown');
    }
    public static function fetchCashBreakdownByCashblotterId($cashblotter_id)
    {
        $cash_breakdown = CashBreakdown::where('cashblotter_id', '=', $cashblotter_id)->first();
        return $cash_breakdown;
    }
}
