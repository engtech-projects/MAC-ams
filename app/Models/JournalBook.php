<?php

namespace App\Models;

use DB;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JournalBook extends Model
{
    use HasFactory;
    use LogsActivity;


    const GENERAL_LEDGER_BOOK = 5;
    const CASH_BLOTTER_BOOKS = [1, 9, 6, 8, 7, 4];
    const LOAN_PAYMENTS_BOOK = 9;
    const CASH_PAID_BOOK = [1, 6, 8, 7, 5];
    const POS_PAYMENT_BOOK = [9];
    const COLLECTION_DEPOSITS_BOOK = 7;
    const INTER_BRANCH_BOOKS = [9, 4];
    const CASH_RECEIPT_BOOK_BOOK = 4;
    const CASH_RECEIVED_BOOKS = [1, 9, 4, 5, 6];
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
    protected static $recordEvents = ['deleted', 'created', 'updated'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->setDescriptionForEvent(fn(string $eventName) => $eventName)
            ->useLogName('Journal Book');
    }

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
        return DB::transaction(function () {
            // Fetch or create the sequence for the current book code
            $sequence = DB::table('journal_sequences')
                ->lockForUpdate()
                ->where('book_code', $this->book_code)
                ->first();

            if ($sequence) {
                // Increment the last number
                $lastNumber = $sequence->last_number + 1;

                // Update the sequence in the table
                DB::table('journal_sequences')
                    ->where('id', $sequence->id)
                    ->update(['last_number' => $lastNumber]);
            } else {
                // Initialize the sequence for the book code
                $lastNumber = 1;

                DB::table('journal_sequences')->insert([
                    'book_code' => $this->book_code,
                    'last_number' => $lastNumber,
                ]);
            }

            // Generate the journal number
            $journalNumber = $this->book_code . '-' . sprintf('%006s', $lastNumber);

            // Save the new journal number as a journal entry
            $this->journalEntries()->create([
                'journal_no' => $journalNumber,
                // Add other necessary fields
            ]);

            return $journalNumber;
        });
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
        if ($id) {
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
