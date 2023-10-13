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
        'status',
        'payee',
        'remarks',
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class,'branch_id');
    }

    public static function fetch($status = '', $from = '', $to = '', $book_id = '', $branch_id = '', $order = 'DESC', $journal_no = '')
    {
        $query = journalEntry::with(['journalDetails', 'bookDetails']);
        // $query = journalEntry::with(['bookDetails']);
        if ($status != '') {
            $query->where('status', $status);
        }
        if ($from != '' && $to != '') {
            $query->whereBetween('journal_date', [$from, $to]);
        }
        if ($book_id != '') {
            $query->where('book_id', $book_id);
        }
        if ($branch_id != '') {
            $query->where('branch_id', $branch_id);
        }
        if ($journal_no != '') {
            $query->where('journal_no', $journal_no);
        }
        if ($order != '') {
            $query->orderBy('journal_date', $order);
        }

        return $query->limit(1000)->get();
    }

    public function journalDetails()
    {
        return $this->hasMany(JournalEntryDetails::class, 'journal_id');
    }
    public function bookDetails()
    {
        return $this->belongsTo(JournalBook::class, 'book_id');
    }

    public function account()
    {
        return $this->belongsTo(Accounts::class, 'account_id');
    }

    public function createJournalEntry($request)
    {
        $requestEntry = $request["journal_entry"];
        $requestDetails = $request["details"];
        $journalEntry = self::create([
            'journal_no' => $requestEntry["journal_no"],
            'journal_date' => $requestEntry["journal_date"],
            'branch_id' => $requestEntry["branch_id"],
            'book_id' => $requestEntry["book_id"],
            'source' => $requestEntry["source"],
            'cheque_date' => $requestEntry["cheque_date"],
            'cheque_no' => $requestEntry["cheque_no"],
            'status' => $requestEntry["status"],
            'payee' => $requestEntry["payee"],
            'remarks' => $requestEntry["remarks"],
            'amount' => $requestEntry["amount"]

        ]);
        $journalEntry->journalDetails()->createMany($requestDetails);

        return $journalEntry;
    }

}
