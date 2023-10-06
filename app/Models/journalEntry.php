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
    public $timestamps = true;

    protected $fillable = [
		'journal_no',
		'journal_date',
		'branch_id',
		'book_id',
		'source',
		'cheque_no',
		'cheque_date',
		'amount',
		'payee',
		'remarks',
    ];

	public static function fetch($status = '', $from = '', $to='', $book_id='', $branch_id='', $order='', $journal_no = '')
	{
		$query = journalEntry::with(['journalDetails','bookDetails']);
		// $query = journalEntry::with(['bookDetails']);
		if($status != '')
		{
			$query->where('status', $status);
		}
		if($from != '' && $to != '')
		{
			$query->whereBetween('journal_date',[$from, $to]);
		}
		if($book_id != '')
		{
			$query->where('book_id',$book_id);
		}
		if($branch_id != '')
		{
			$query->where('branch_id',$branch_id);
		}
		if($journal_no != '')
		{
			$query->where('journal_no',$journal_no);
		}
		if( $order != '' ) {
			$query->orderBy('journal_date', $order);
		}

		return $query->limit(1000)->paginate(10);
	}

	public function journalDetails(){
		return $this->hasMany(JournalEntryDetails::class, 'journal_id');
	}
	public function bookDetails(){
		return $this->belongsTo(JournalBook::class, 'book_id');
	}

}
