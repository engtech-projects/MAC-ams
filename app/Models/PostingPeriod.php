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

    public function isInPostingPeriod($date, $posting_period)
    {
        $transaction_date = Carbon::parse($date);
        $start_date = Carbon::parse($posting_period->start_date);
        $end_date = Carbon::parse($posting_period->end_date);

        return $transaction_date->between($start_date, $end_date, false);
    }
}
