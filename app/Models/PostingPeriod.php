<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostingPeriod extends Model
{
    use HasFactory;

    protected $fillable = [
        'start_date',
        'end_date',
        'status',
        'posting_period'
    ];

    const OPEN_STATUS = 'open';

    public function scopeOpenStatus(Builder $query): void
    {
        $query->where('status', 'open');
    }

    public function isInPostingPeriod($journal_date, $posting_period)
    {
        $transaction_date = Carbon::parse($journal_date);
        $start_date = Carbon::parse($posting_period->start_date);
        $end_date = Carbon::parse($posting_period->end_date);
        /* dd($start_date,$end_date); */
        if($transaction_date->gt($start_date) || $transaction_date->eq($start_date) && $transaction_date->lt($end_date) || $transaction_date->eq($end_date)) {
            return true;
        }
        return false;
        /* return $transaction_date->between($start_date, $end_date, false); */
    }
}
