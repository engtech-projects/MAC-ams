<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PostingPeriod extends Model
{
    use HasFactory;

    protected $fillable = [
        'start_date',
        'end_date',
        'status',
        'posting_period'
    ];
    protected static $recordEvents = ['deleted', 'created'];

    const OPEN_STATUS = 'open';

    public function getModelName()
    {

        return class_basename($this);
    }

    public function scopeOpenStatus(Builder $query): void
    {
        $query->where('status', 'open');
    }

    public function isInPostingPeriod($journal_date, $posting_period)
    {
        $transaction_date = Carbon::parse($journal_date);
        $start_date = Carbon::parse($posting_period->start_date);
        $end_date = Carbon::parse($posting_period->end_date);
        return $transaction_date->between($start_date, $end_date, true);
    }
}
