<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
        return $query->where('journal_entry.status', self::STATUS_POSTED);
    }


    public function journalEntryDetails()
    {
        return $this->hasMany(journalEntryDetails::class, 'journal_id', 'journal_id');
    }

    public static function fetch($status = '', $from = '', $to = '', $book_id = '', $branch_id = '', $order = 'ASC', $journal_no = '', $journal_source = '', $journal_payee = '')
    {
        if (!$branch_id && !Gate::allows('manager')) {
            $branch_id = session()->get('auth_user_branch');
        }

        $query = journalEntry::with(['journalDetails', 'bookDetails']);
        // $query = journalEntry::with(['bookDetails']);
        if ($status != '') {
            $query->where('status', $status);
        }
        if ($journal_source != '') {
            $query->where('source', $journal_source);
        }
        if ($journal_payee != '') {
            $query->where('payee', $journal_payee);
        }
        if ($from != '' && $to != '') {
            $query->whereBetween('journal_date', [$from, $to]);
            if ($journal_no != '') {
                $query->orWhere('journal_no', $journal_no);
            }
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
        $result = $query->get();


        return $query->get();
    }

    public function details()
    {
        return $this->hasMany(journalEntryDetails::class, 'journal_id', 'journal_id');
    }

    public function journalDetails()
    {
        return $this->hasManyThrough(Accounts::class, journalEntryDetails::class, 'journal_id', 'account_id');
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
        $branchId = isset($requestEntry['branch_id']) ? $requestEntry["branch_id"] : session()->get('auth_user_branch');

        $journalEntry = self::create([
            'journal_no' => $requestEntry["journal_no"],
            'journal_date' => $requestEntry["journal_date"],
            'branch_id' => $branchId,
            'book_id' => $requestEntry["book_id"],
            'source' => $requestEntry["source"],
            'cheque_date' => $requestEntry["cheque_date"],
            'cheque_no' => $requestEntry["cheque_no"],
            'status' => $requestEntry["status"],
            'payee' => $requestEntry["payee"],
            'remarks' => $requestEntry["remarks"],
            'amount' => $requestEntry["amount"]

        ]);
        $journalEntry->details()->createMany($requestDetails);
        return $journalEntry;
    }

    public function getBeginningBalance($transactionDate, $branchId)
    {
        $bal = CollectionBreakdownBeginningBalance::where('branch_id', $branchId)->first();
        $entries = journalEntry::select('journal_id', 'book_id', 'status', 'cheque_no', 'cheque_date', 'journal_date', 'source', 'journal_no', 'branch_id')
            /* ->whereBetween('journal_date',  ['2024-05-02', $transactionDate]) */
            ->whereDate('journal_date', '>', '2024-04-30')
            ->whereDate('journal_date', '<', $transactionDate)
            ->posted()
            ->when($branchId, function ($query, $branchId) {
                $query->where('branch_id', $branchId);
            })
            ->with([
                'branch' => function ($query) {
                    $query->select('branch_id', 'branch_name');
                },
                'details' => function ($query) {
                    $query->select('journal_id', 'account_id', 'journal_details_debit AS cash_in', 'journal_details_credit AS cash_out')
                        ->whereIn('account_id', [
                            // Accounts::CASH_IN_BANK_BDO_ACC,
                            // Accounts::CASH_IN_BANK_MYB_ACC,
                            Accounts::CASH_ON_HAND_ACC,
                            // Accounts::PAYABLE_CHECK_ACC,
                            // Accounts::DUE_TO_HO_BXU_BRANCH_NASIPIT_ACC,
                        ]);
                }
            ])->get();
        $entries->map(function ($item) {
            $item['total'] = [
                'cash_in' => $item->details->sum('cash_in'),
                'cash_out' => $item->details->sum('cash_out')
            ];
            return $item;
        });
        $cashRecieved = 0;
        $cashPaid = 0;
        foreach ($entries as $val) {
            $cashRecieved += $val['total']['cash_in'];
            $cashPaid += $val['total']['cash_out'];
        }
        $total = ($bal->balance + $cashRecieved) - $cashPaid;
        /*         dd($total); */
        /* dd(['BGN_BAL' => CollectionBreakdown::BEGINNING_BAL, 'CSHPD' => $cashPaid, 'CSHRCV' => $cashRecieved]); */
        /*         return $bal; */
        return $total;
    }

    public function getCashBlotterEntries($id, $branchId)
    {

        $books = new JournalBook();
        $collectionBreakdown = new CollectionBreakdown();
        $collections = $collectionBreakdown->getCollectionBreakdown($id);

        $books = $books->getCashBlotterBooks();
        $prevCollection = $collectionBreakdown->getPreviousCollection($id);

        //$transactionDate = $prevCollection ? $prevCollection["transaction_date"] : null;
        $transactionDate = Carbon::createFromFormat('Y-m-d', $collections->transaction_date);
        $bal = $this->getBeginningBalance($transactionDate, $branchId);

        $entries = journalEntry::select('journal_id', 'book_id', 'status', 'cheque_no', 'cheque_date', 'journal_date', 'source', 'journal_no', 'branch_id')
            ->whereDate('journal_date', '=', $transactionDate)
            ->posted()
            ->when($branchId, function ($query, $branchId) {
                $query->where('branch_id', $branchId);
            })->with([
                'branch' => function ($query) {
                    $query->select('branch_id', 'branch_name');
                },
                'details' => function ($query) {
                    $query->select('journal_id', 'account_id', 'journal_details_debit AS cash_in', 'journal_details_credit AS cash_out')->whereIn('account_id', [
                        Accounts::CASH_IN_BANK_BDO_ACC,
                        Accounts::CASH_IN_BANK_MYB_ACC,
                        Accounts::CASH_ON_HAND_ACC,
                        Accounts::PAYABLE_CHECK_ACC,
                        Accounts::DUE_TO_HO_BXU_BRANCH_NASIPIT_ACC,
                    ]);
                }
            ])->get();


        $collectionEntries = [
            'begining_balance' => [
                'transaction_date' => $prevCollection ? $prevCollection["prev_transaction_date"] : null,
                'total' => $transactionDate->lt('2024-05-01') ? $collections->total : $bal //$prevCollection ? $prevCollection["total"] : 0
            ],
            'cash_received' => $this->mapCashBlotterEntries($entries, JournalBook::CASH_RECEIVED_BOOKS, Accounts::CASH_ON_HAND_ACC, journalBook::BOOK_DEBIT),
            'cash_paid' => $this->mapCashBlotterEntries($entries, JournalBook::CASH_PAID_BOOK, Accounts::CASH_ON_HAND_ACC, journalBook::BOOK_CREDIT),
            'pos_payment' => $this->mapCashBlotterEntries($entries, JournalBook::LOAN_PAYMENTS_BOOK, Accounts::CASH_IN_BANK_BDO_ACC, journalBook::BOOK_DEBIT, 'pos_payment'),
            'check_payment' => $this->mapCashBlotterEntries($entries, JournalBook::POS_PAYMENT_BOOK, Accounts::PAYABLE_CHECK_ACC, journalBook::BOOK_DEBIT, 'check_payment'),
            'pdc_deposit' => $this->mapCashBlotterEntries($entries, JournalBook::COLLECTION_DEPOSITS_BOOK, Accounts::PAYABLE_CHECK_ACC, journalBook::BOOK_CREDIT, 'pdc_deposit'),
            'interbranch' => $this->getInterBranchEntries($transactionDate, $branchId),
            'collections' => $collections
        ];
        return collect($collectionEntries);
    }

    public function getInterBranchEntries($transactionDate, $branchId)
    {
        $entries = journalEntry::select('journal_id', 'book_id', 'status', 'cheque_no', 'cheque_date', 'journal_date', 'source', 'journal_no', 'branch_id')
            ->whereDate('journal_date', '=', $transactionDate)
            ->where(['branch_id' => $branchId])
            ->with('branch:branch_id,branch_name')
            ->whereIn('book_id', JournalBook::INTER_BRANCH_BOOKS)
            ->posted()
            ->with([
                'details' => function ($query) {
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
            $entry["details"] = collect($entry["details"])->filter(function ($detail) use ($account, $type, $transaction) {
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
            if (count($entry["details"]) > 0) {
                return $entry;
            }
        })->filter()->values();
        return $data;
    }



    public function getJournalEntry(array $filter)
    {

        $journalEntry = Accounts::query()
            ->when($filter, function ($query, $filter) {
                $query->when(isset($filter['account_id']), function ($query) use ($filter) {
                    $query->where('account_id', $filter['account_id']);
                })
                    ->with('entries', function ($query) use ($filter) {
                        $query->select([
                            'journal_entry_details.journal_details_id',
                            'journal_entry.journal_id',
                            'journal_entry_details.account_id',
                            'journal_entry.journal_no',
                            'journal_entry.source',
                            'journal_entry.cheque_no',
                            'journal_entry.journal_date',
                            'journal_entry.branch_id',
                            'journal_entry.status',
                            'journal_entry_details.journal_details_debit as debit',
                            'journal_entry_details.journal_details_credit as credit'
                        ])->when(isset($filter['as_of']), function ($query) use ($filter) {
                            $query->where('journal_entry.journal_date', '<=', $filter['as_of']);
                        })->when(isset($filter["date_from"]) && isset($filter["date_to"]), function ($query) use ($filter) {
                            $query->whereBetween('journal_entry.journal_date', [$filter['date_from'], $filter['date_to']]);
                        })
                            ->posted()
                            ->with('branch:branch_id,branch_code,branch_name');
                    });
            })
            ->select('account_id', 'account_number', 'account_name')
            ->get();
        return $journalEntry;
    }


    public function getSubsidiaryListing(array $filter)
    {
        $collections = collect($this->getJournalEntry($filter));

        $subsidiaryListing = $collections->map(function ($item, $key) {
            $item["entries"] = collect($item["entries"])->groupBy(function ($item) {
                return $item["branch"] == null ? "NO BRANCH" : $item["branch"]["branch_code"] . ' ' . $item["branch"]["branch_name"];
            });

            $data = [
                "account_id" => $item["account_id"],
                "account_number" => $item["account_number"],
                "account_name" => $item["account_name"],
                "entries" => $item["entries"],
            ];
            $data["entries"] = collect($data["entries"])->map(function ($item) {

                $newJournalEntryCollection = [];
                $balance = 0;
                $item = collect($item)->sortByDesc("journal_date");
                $item->each(function ($item) use (&$newJournalEntryCollection, &$balance) {
                    $balance -= $item["credit"];
                    $balance += $item["debit"];
                    $newJournalEntryCollection[] = [
                        "journal_date" => $item["journal_date"],
                        "account_id" => $item["account_id"],
                        "branch_id" => $item["branch_id"],
                        "journal_no" => $item["journal_no"],
                        "cheque_no" => $item["cheque_no"],
                        "cheque_date" => $item["cheque_date"],
                        "source" => $item["source"],
                        "credit" => $item["credit"],
                        "debit" => $item["debit"],
                        "balance" => $balance
                    ];
                    return $item;
                });

                return $newJournalEntryCollection;
            });
            return $data;
        })->values()->all();
        dd($subsidiaryListing);

        return $subsidiaryListing;
    }

    public function getBankReconciliationReport(array $filter)
    {
        $collections = collect($this->getJournalEntry($filter));
        $journalEntries = $collections->map(function ($item, $key) {
            $data = [
                "account_id" => $item["account_id"],
                "account_name" => $item["account_name"],
                "account_number" => $item["account_number"],
                "entries" => collect($item["entries"])->map(function ($item) {
                    return [

                        "journal_details_id" => $item["journal_details_id"],
                        "journal_id" => $item["journal_id"],
                        "journal_no" => $item["journal_no"],
                        "account_id" => $item["account_id"],
                        "source" => $item["source"],
                        "cheque_no" => $item["cheque_no"],
                        "journal_date" => $item["journal_date"],
                        "status" => "CLEARED",
                        //$item["status"],
                        "deposits" => $item["debit"],
                        "withdrawals" => $item["credit"]
                    ];
                })
            ];
            $data["entries"] = collect($data["entries"])->sortByDesc(['withdrawals', 'journal_date']);
            return $data;
        })
            ->values();
        return $journalEntries;

        // return $collections;
    }
}
