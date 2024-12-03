<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class JournalBook extends Model
{
    use HasFactory;


    const CASH_BLOTTER_BOOKS = [1, 9, 6, 8, 7, 4];
    const LOAN_PAYMENTS_BOOK = 9;
    const CASH_PAID_BOOK = [6, 8, 7, 5];
    const POS_PAYMENT_BOOK = [9];
    const COLLECTION_DEPOSITS_BOOK = 7;
    const INTER_BRANCH_BOOKS = [9, 4];
    const CASH_RECEIPT_BOOK_BOOK = 4;
    const CASH_RECEIVED_BOOKS = [1, 9, 4, 5,6];
    const BOOK_CREDIT = 'credit';
    const BOOK_DEBIT = 'debit';



    protected $table = 'journal_book';
    protected $primaryKey = 'book_id';

    protected $fillable = [
        'book_code',
        'book_name',
        'book_src',
        'book_ref',
        'book_head',
        'book_flag',
    ];

    public static function getBookWithJournalCount()
    {
        return DB::table("journal_book")
            ->leftJoin("journal_entry", function ($join) {
                $join->on("journal_book.book_id", "=", "journal_entry.book_id");
            })
            ->selectRaw("journal_book.*, COUNT(journal_entry.journal_id) as ccount")
            ->groupBy("journal_book.book_id")
            ->get();
    }

    public function generateJournalNumber()
    {
        $entry = $this->journalEntries()->whereNotNull('journal_no')->orderBy('journal_id', 'desc')->first();

        if ($entry) {
            $series = explode('-', $entry->journal_no);
            $lastNumber = (int)$series[1];
            $journalNumber = $this->book_code . '-' . sprintf('%006s', $lastNumber + 1);
        } else {
            $journalNumber = $this->book_code . '-' . sprintf('%006s', 1);
        }
        return $journalNumber;
    }


    public function scopeCashReceivedBook($query)
    {
        return $query->whereIn('book_id', self::CASH_RECEIVED_BOOK);
    }
    public function scopeCashPaidBook($query)
    {
        return $query->whereIn('book_id', self::CASH_PAID_BOOK);
    }

    public function checkBookCode($code, $id = null)
    {
        $query = $this->where('book_code', $code);
        if($id){
            $query->where('book_id', '!=', $id);
        }
        $data = $query->get();
        
        return $data->isNotEmpty();
    }

    public function journalEntries()
    {
        return $this->hasMany(journalEntry::class, 'book_id', 'book_id');
    }


    public function getCashBlotterBooks()
    {
        $books = self::whereIn('book_id', self::CASH_BLOTTER_BOOKS)->get(['book_id', 'book_code', 'book_name']);
        return $books;
    }
}
