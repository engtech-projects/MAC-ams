<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class JournalBook extends Model
{
    use HasFactory;


    const CASH_BLOTTER_BOOKS = [1, 9,6,8];
    const LOAN_PAYMENTS_BOOK = 9;
    const CASH_PAID_BOOK = [6,8];



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

    public function scopeCashReceivedBook($query)
    {
        return $query->whereIn('book_id', self::CASH_RECEIVED_BOOK);
    }
    public function scopeCashPaidBook($query)
    {
        return $query->whereIn('book_id',self::CASH_PAID_BOOK);
    }

    public function checkBookCode($code, $id)
    {
        $data = $this->where('book_code', $code)->Where('book_id', $id)->get();
        if (count($data) > 0) {
            return true;
        }
        return false;
    }

    public function journalEntries()
    {
        return $this->hasMany(journalEntry::class, 'book_id', 'book_id');
    }

}
