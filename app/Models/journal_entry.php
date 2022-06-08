<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class journalEntry extends Model
{
    use HasFactory;
    protected $table = 'journal_entry';
	protected $primaryKey = 'journal_id';
    public $timestamps = false;

    protected $fillable = [
		'journal_no',
		'journal_date',
		'branch_id',
		'book_id',
		'source',
		'cheque_no',
		'amount',
		'payee',
		'remarks',
    ];
	
	public function journalDetails(){
		return $this->belongsTo(JournalEntryDetails::class, 'journal_id');
	}

}
