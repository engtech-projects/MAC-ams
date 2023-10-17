<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    public static function fetchCashBreakdownByCashblotterId($cashblotter_id)
    {
        $cash_breakdown = CashBreakdown::where('cashblotter_id', '=', $cashblotter_id)->first();
        return $cash_breakdown;
    }
    public static function getBeginningBalance($transactionDate)
    {
        $date = $transactionDate->format('Y-m-d');
        $beginningBalance = CashBreakdown::whereDate('created_at', '=', $date)->pluck('total_amount')->first();
        return $beginningBalance;

    }
}
