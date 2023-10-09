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

    public function subsidiary()
    {
        return $this->belongsTo(Subsidiary::class, 'subsidiary_id');
    }
    public function chartOfAccount()
    {
        return $this->belongsTo(Accounts::class, 'account_id');
    }


    public function createJournalDetails()
    {

    }

}
