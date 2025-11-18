<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrepaidExpensePayment extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $table = 'prepaid_expense_payments';
    protected $fillable = [
        'amount',
        'payment_date',
        'status',
        'p_expensse_id'
    ];
    const STATUS_POSTED = 'posted';

    public function scopeUnposted($query)
    {
        return $query->where('status', 'unposted');
    }
}