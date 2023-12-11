<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class journalEntryDetails extends Model
{
    use HasFactory;


    protected $table = 'journal_entry_details';
    protected $primaryKey = 'journal_details_id';
    public $timestamps = false;

    const CASH_ON_HAND_ACC = 3;
    protected $fillable = [
        'journal_id',
        'account_id',
        'subsidiary_id',
        'journal_details_account_no',
        'journal_details_title',
        'journal_details_debit',
        'journal_details_credit',
        'journal_details_ref_no',
        'status',
        'balance'
    ];

    public function journal()
    {
        return $this->belongsTo(journalEntry::class, 'journal_id');
    }
    public function journalEntry()
    {
        return $this->belongsTo(journalEntry::class, 'journal_id', 'journal_id');
    }
    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }

    public function branches()
    {
        return $this->hasOneThrough(Branch::class, journalEntry::class, 'journal_id', 'branch_id');
    }


    public function scopeDebit($query)
    {
        return $query->where('journal_details_credit', '=', 0);
    }
    public function scopeCashOnHand($query)
    {
        return $query->where('account_id', self::CASH_ON_HAND_ACC);
    }
    public function scopeCredit($query)
    {
        return $query->where('journal_details_debit', '=', 0);
    }

    public function subsidiary()
    {
        return $this->belongsTo(Subsidiary::class, 'subsidiary_id');
    }
    public function account()
    {
        return $this->belongsTo(Accounts::class, 'account_id');
    }

    public function createJournalDetails()
    {

    }

}
