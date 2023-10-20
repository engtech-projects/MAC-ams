<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class journalEntry extends Model
{
    use HasFactory;
    protected $table = 'journal_entry';
    protected $primaryKey = 'journal_id';
    public $timestamps = true;

    const STATUS_POSTED = 'posted';
    const CASH_RECEIVED_ACC = [];

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
        return $this->belongsTo(Branch::class, 'branch_id');
    }

    public function scopePosted($query)
    {
        return $query->where('status', self::STATUS_POSTED);
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
        return $this->hasMany(journalEntryDetails::class, 'journal_id');
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


    public function getCashBlotterEntries($id, $branchId)
    {

        $books = new JournalBook();
        $collectionBreakdown = new CollectionBreakdown();
        $collections = $collectionBreakdown->getCollectionBreakdown($id);
        $books = $books->getCashBlotterBooks();
        $prevCollection = $collectionBreakdown->getPreviousCollection($id);
        $transactionDate = $prevCollection ? $prevCollection["transaction_date"] : null;
        $entries = journalEntry::select('journal_id', 'book_id', 'status', 'cheque_no', 'cheque_date', 'journal_date', 'source', 'journal_no', 'branch_id')
            ->whereDate('journal_date', '=', $transactionDate)
            ->posted()
            ->when($branchId, function ($query, $branchId) {
                $query->where('branch_id', $branchId);
            })->with([
                    'branch' => function ($query) {
                        $query->select('branch_id', 'branch_name');
                    },
                    'journalDetails' => function ($query) {
                        $query->select('journal_id', 'account_id', 'journal_details_debit AS cash_in', 'journal_details_credit AS cash_out')->whereIn('account_id', [
                            Accounts::CASH_IN_BANK_BDO_ACC,
                            Accounts::CASH_IN_BANK_MYB_ACC,
                            Accounts::CASH_ON_HAND_ACC,
                            Accounts::PAYABLE_CHECK_ACC,
                            Accounts::DUE_TO_HO_BXU_BRANCH_NASIPIT_ACC,
                        ]);
                    }
                ])->get();


        /* foreach ($books as $bKey => $book) {
            $entries[] = $book->load([
                'journalEntries' => function ($query) use ($branchId, $transactionDate) {
                    $query->select('journal_id', 'book_id', 'status', 'cheque_no', 'cheque_date', 'journal_date', 'source', 'journal_no', 'branch_id')
                        ->whereDate('journal_date', '=', $transactionDate)
                        ->posted()
                        ->when($branchId, function ($query, $branchId) {
                            $query->where('branch_id', $branchId);
                        })->with([
                                'branch' => function ($query) {
                                    $query->select('branch_id', 'branch_name');
                                },
                                'journalDetails' => function ($query) {
                                    $query->select('journal_id', 'account_id', 'journal_details_debit AS cash_in', 'journal_details_credit AS cash_out')->whereIn('account_id', [
                                        Accounts::CASH_IN_BANK_BDO_ACC,
                                        Accounts::CASH_IN_BANK_MYB_ACC,
                                        Accounts::CASH_ON_HAND_ACC
                                    ]);
                                }
                            ]);
                }
            ]);
        } */

        $collectionEntries = [
            'begining_balance' => [
                'transaction_date' => $prevCollection ? $prevCollection["prev_transaction_date"] : null,
                'total' => $prevCollection ? $prevCollection["total"] : 0
            ],
            'cash_received' => $this->mapCashBlotterEntries($entries, JournalBook::CASH_RECEIVED_BOOKS, Accounts::CASH_ON_HAND_ACC, journalBook::BOOK_DEBIT),
            'cash_paid' => $this->mapCashBlotterEntries($entries, JournalBook::CASH_PAID_BOOK, Accounts::CASH_ON_HAND_ACC, journalBook::BOOK_CREDIT),
            'pos_payment' => $this->mapCashBlotterEntries($entries, JournalBook::LOAN_PAYMENTS_BOOK, Accounts::CASH_IN_BANK_BDO_ACC, journalBook::BOOK_DEBIT, 'pos_payment'),
            'check_payment' => $this->mapCashBlotterEntries($entries, JournalBook::POS_PAYMENT_BOOK, Accounts::PAYABLE_CHECK_ACC, journalBook::BOOK_DEBIT, 'check_payment'),
            'pdc_deposit' => $this->mapCashBlotterEntries($entries, JournalBook::COLLECTION_DEPOSITS_BOOK, Accounts::PAYABLE_CHECK_ACC, journalBook::BOOK_CREDIT, 'pdc_deposit'),
            'interbranch' => $this->getInterBranchEntries($transactionDate),
            'collections' => $collections
        ];
        return collect($collectionEntries);
    }

    public function getInterBranchEntries($transactionDate)
    {
        $entries = journalEntry::select('journal_id', 'book_id', 'status', 'cheque_no', 'cheque_date', 'journal_date', 'source', 'journal_no', 'branch_id')
            ->whereDate('journal_date', '=', $transactionDate)
            ->whereIn('book_id', JournalBook::INTER_BRANCH_BOOKS)
            ->posted()
            ->with([
                'journalDetails' => function ($query) {
                    $query->select('journal_id', 'account_id', 'journal_details_debit AS cash_in', 'journal_details_credit AS cash_out')->whereIn('account_id', [
                        Accounts::DUE_TO_HO_BXU_BRANCH_NASIPIT_ACC,
                    ]);
                }
            ])->get();

        return $this->mapCashBlotterEntries($entries, JournalBook::INTER_BRANCH_BOOKS, Accounts::DUE_TO_HO_BXU_BRANCH_NASIPIT_ACC, null, 'inter_branch');
    }
    public function mapCashBlotterEntries($entries, $books = [], $account, $type, $transaction = null)
    {
        $data = collect($entries)->filter(function ($item) use ($books) {

            if (is_array($books)) {
                return in_array($item["book_id"], $books);
            } else {
                return $item["book_id"] == $books;
            }

        })->map(function ($item) use ($account, $type, $transaction) {
            $entry = collect($item);

            $entry["journal_details"] = collect($entry["journal_details"])->filter(function ($detail) use ($account, $type, $transaction) {
                if ($type === JournalBook::BOOK_DEBIT) {
                    return $detail["account_id"] == $account && $detail["cash_out"] == 0;
                } else if ($type === JournalBook::BOOK_CREDIT) {
                    return $detail["account_id"] == $account && $detail["cash_in"] == 0;
                }
                return $detail;
            })->map(function ($detail) use ($transaction) {
                if ($transaction === 'pos_payment' || $transaction == 'check_payment') {
                    $detail["cash_out"] = $detail["cash_in"];
                } else if ($transaction == 'pdc_deposit') {
                    $detail["cash_in"] = $detail["cash_out"];
                }
                return $detail;
            })->filter()->values();
            return $entry;
        })->map(function ($entry) {
            if (count($entry["journal_details"]) > 0) {
                return $entry;
            }
        })->filter()->values();
        return $data;
    }

}
