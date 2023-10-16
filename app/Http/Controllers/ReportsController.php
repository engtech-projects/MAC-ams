<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Transactions;
use App\Models\PaymentMethod;
use App\Models\Accounts;
use App\Models\AccountOfficer;
use App\Models\AccountCategory;
use App\Models\AccountType;
use App\Models\TransactionType;
use App\Models\TransactionStatus;
use App\Models\Subsidiary;
use App\Models\SubsidiaryCategory;
use App\Http\Controllers\PrinterController;
use App\Http\Controllers\AccountsController;
use App\Models\AccountOfficerCollection;
use App\Models\Branch;
use App\Models\BranchCollection;
use App\Models\CashBlotter;
use App\Models\CashBreakdown;
use App\Models\journalEntry;
use App\Models\journalEntryDetails;
use App\Models\JournalBook;
use App\Models\TransactionDate;
use App\Repositories\Reports\ReportsRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\Accounting;
use App\Models\OpeningBalance;

class ReportsController extends MainController
{



    public function journalLedger(Request $request)
    {
        /* ----- start journal ledger ----- */

        $accounting = Accounting::getFiscalYear();
        $from = $request->from ? $request->from : $accounting->start_date;
        $to = $request->to ? $request->to : $accounting->end_date;
        $branch_id = $request->branch_id ? $request->branch_id : '';
        $status = $request->status ? $request->status : null;
        $book_id = $request->book_id ? $request->book_id : '';
        $journal_no = $request->journal_no ? $request->journal_no : '';

        // $branch = Branch::find($branch_id);
        $journal_entry = journalEntry::fetch($status, $from, $to, $book_id, $branch_id, 'DESC', $journal_no);
        $journal_ledger = [];

        foreach ($journal_entry as $entry) {

            $entries = [];

            foreach ($entry->journalDetails as $details) {
                $subsidiary = '';

                if ($details->subsidiary_id) {
                    $subsidiary = Subsidiary::where(['sub_id' => $details->subsidiary_id])->get()->first()->sub_name;
                }

                $entries[] = [
                    'account' => $details->journal_details_account_no,
                    'title' => $details->journal_details_title,
                    'subsidiary' => $subsidiary,
                    'debit' => $details->journal_details_debit,
                    'credit' => $details->journal_details_credit
                ];
            }

            $entry->reference_name = '';
            $branch = Branch::find($entry->branch_id);

            if ($branch) {
                $entry->reference_name = $branch->branch_name;
            }

            $journal_ledger[] = [
                'date' => Carbon::parse($entry->journal_date)->format('m/d/Y'),
                'reference' => $entry->journal_no,
                'source' => $entry->source,
                'reference_name' => $entry->reference_name,
                'remarks' => $entry->remarks,
                'status' => $entry->status,
                'details' => $entries
            ];
        }



        $currentPage = $request->page ? $request->page : 1;

        /* ----- end journal ledger ----- */
        $paginated = $this->paginate($journal_ledger, $currentPage);
        $data = [
            'title' => 'Journal Ledger',
            'journalBooks' => JournalBook::getBookWithJournalCount(),
            'jLedger' => $journal_ledger,
            'paginated' => $paginated,
            'paginationLinks' => $journal_entry
        ];


        return view('reports.sections.journalledger', $data);
    }

    public function paginate($items, $currentPage, $perPage = 5, $page = null)
    {
        return new LengthAwarePaginator(array_slice($items, ($currentPage - 1) * $perPage, $perPage), count($items), $perPage, $currentPage, ['path' => url()->current()]);
    }
    // invoice
    public function subsidiaryLedger()
    {

        $data = [
            'subsidiaryData' => Subsidiary::get(),
            'sub_categories' => SubsidiaryCategory::get(),
            'title' => 'Subsidiary Ledger',
            'subsidiaryLedgerList' => ''
        ];

        return view('reports.sections.subsidiaryledger', $data);
    }
    public function subsidiarySaveorEdit(Request $request)
    {
        if ($request->sub_id == '') {
            $sub = new Subsidiary;
            $sub->sub_id = $request->sub_id;
            $sub->sub_cat_id = $request->sub_cat_id;
            $sub->sub_name = $request->sub_name;
            $sub->sub_address = $request->sub_address;
            $sub->sub_tel = $request->sub_tel;
            $sub->sub_acct_no = $request->sub_acct_no;
            $sub->sub_per_branch = $request->sub_per_branch;
            $sub->sub_date = $request->sub_date;
            $sub->sub_amount = $request->sub_amount;
            $sub->sub_no_depre = $request->sub_no_depre;
            $sub->sub_life_used = $request->sub_life_used;
            $sub->sub_no_amort = $request->sub_no_amort;
            $sub->sub_salvage = $request->sub_salvage;
            $sub->sub_date_post = $request->sub_date_post;
            if ($sub->save()) {
                return json_encode(['message' => 'save', 'sub_id' => $sub->sub_id]);
            }
        } else {
            $sub = Subsidiary::find($request->sub_id);
            $sub->sub_cat_id = $request->sub_cat_id;
            $sub->sub_name = $request->sub_name;
            $sub->sub_address = $request->sub_address;
            $sub->sub_tel = $request->sub_tel;
            $sub->sub_acct_no = $request->sub_acct_no;
            $sub->sub_per_branch = $request->sub_per_branch;
            $sub->sub_date = $request->sub_date;
            $sub->sub_amount = $request->sub_amount;
            $sub->sub_no_depre = $request->sub_no_depre;
            $sub->sub_life_used = $request->sub_life_used;
            $sub->sub_no_amort = $request->sub_no_amort;
            $sub->sub_salvage = $request->sub_salvage;
            $sub->sub_date_post = $request->sub_date_post;
            if ($sub->save()) {
                return json_encode(['message' => 'update', 'sub_id' => $sub->sub_id]);
            }
        }
        return false;
    }





    public function generalLedgerFetchAccount(Request $request)
    {


        if ($request->id != '') {
            $id = $request->id;
            $genLedgerFrom = $request->genLedgerFrom;
            $genLedgerTo = $request->genLedgerTo;

            $journalEntries = Accounts::generalLedger_fetchAccounts($genLedgerFrom, $genLedgerTo, $id);
            return json_encode($journalEntries);

        } else {
            $journalEntries = Accounts::generalLedger_fetchAccounts();
            return json_encode($journalEntries);

        }


    }


    public function subsidiaryViewInfo(Request $request)
    {
        $data = Subsidiary::where('sub_id', $request->id)->get();
        if (count($data) > 0) {
            return json_encode($data);
        }
        return false;
    }

    public function subsidiaryDelete(Request $request)
    {
        if (Subsidiary::find($request->id)->delete()) {
            return json_encode(['message' => 'delete', 'sub_id' => $request->sub_id]);
        }
        return false;
    }

    /* public function searchIndex() {
        $transactions = Accounts::generalLedger_fetchAccounts();
            $balance = 0;
            foreach ($transactions as $transaction) {
                $balance += $transaction->journal_details_debit;
                $balance -= $transaction->journal_details_credit;
                journalEntryDetails::where('journal_details_id',$transaction->journal_details_id)
                ->update(['balance' => $balance]);
            }
            $data = [
                'title' => 'General Ledger',
                'chartOfAccount' => Accounts::get(),
                'generalLedgerAccounts' => Accounts::generalLedger_fetchAccounts(),
                'transactions' => $transactions,
            ];
            return view('reports.sections.generalledger', $data);
    } */
    /* public function searchLedger(Request $request) {
        return $request;
    }
 */
    public function generalLedger(Request $request)
    {
        $accounting = Accounting::getFiscalYear();
        $from = $request->from ? $request->from : $accounting->start_date;
        $to = $request->to ? $request->to : $accounting->end_date;
        $account_id = !$request->account_id || $request->account_id == 'all' ? '' : $request->account_id;
        $transactions = Accounts::generalLedger_fetchAccounts($from, $to, $account_id);
        // dd($transactions);


        // echo '<pre>';
        // var_export(Accounts::generalLedger_fetchAccounts()->toArray());
        // echo '</pre>';
        $data = [
            'title' => 'General Ledger',
            'chartOfAccount' => Accounts::where(['type' => 'L'])->get(),
            'generalLedgerAccounts' => Accounts::generalLedger_fetchAccounts(),
            'transactions' => $transactions,
        ];
        return view('reports.sections.generalledger', $data);

    }


    public function trialBalance(Request $request)
    {
        $accounts = [];
        $fiscalYear = Accounting::getFiscalyear();
        $accounts = Accounts::getTrialBalance($fiscalYear->start_date, TransactionDate::get_date());
        $accounts = $accounts->toArray();
        $currentPage = $request->page ? $request->page : 1;
        $perPage = 25;
        $data = [
            'title' => 'Subsidiary Ledger',
            'trialBalance' => $accounts,
            'paginated' => new LengthAwarePaginator(
                array_slice($accounts, ($currentPage - 1) * $perPage, $perPage),
                count($accounts),
                $perPage,
                $currentPage,
                [
                    'path' => url()->current(),
                    // Set the current URL as the base URL for pagination links
                ]
            ),
            'trialbalanceList' => '',
            'transactionDate' => TransactionDate::get_date()
        ];
        return view('reports.sections.trialBalance', $data);
    }

    public function incomeStatement()
    {
        $data = [
            'title' => 'Subsidiary Ledger',
            'trialbalanceList' => ''
        ];
        return view('reports.sections.incomeStatement', $data);
    }

    public function bankReconcillation()
    {
        $data = [
            'title' => 'Subsidiary Ledger',
            'trialbalanceList' => ''
        ];
        return view('reports.sections.bankReconcillation', $data);
    }

    public function cashPosition()
    {
        $data = [
            'title' => 'Subsidiary Ledger',
            'trialbalanceList' => ''
        ];

        return view('reports.sections.cashPosition', $data);
    }

    public function cashTransactionBlotter(Request $request)
    {
        $journalBook = new JournalBook();
        $branchId = 1;
        $books = $journalBook->whereIn('book_id', $journalBook::CASH_BLOTTER_BOOKS)->with([
            'journalEntries' => function ($query) use ($branchId) {
                $query->select(['book_id', 'journal_no', 'journal_date', 'branch_id', 'journal_id', 'source', 'cheque_date', 'cheque_no'])->posted()
                    ->when($branchId, function ($query, $branchId) {
                        $query->where('branch_id', $branchId);
                    })->with([
                            'branch' => function ($query) {
                                $query->select('branch_id', 'branch_name');
                            }
                        ])->whereHas('journalDetails', function ($query) {
                            $query->where('account_id', 3);
                        })->with('journalDetails', function ($query) {
                    $query->select('journal_id', 'account_id', 'journal_details_debit', 'journal_details_credit')->whereIn(
                        'account_id',
                        [Accounts::CASH_ON_HAND_ACC, Accounts::CASH_IN_BANK_BDO_ACC, Accounts::CASH_IN_BANK_MYB_ACC]
                    );
                });
            }
        ])->get(['book_id', 'book_name', 'book_code', 'book_ref']);

        $collection = collect($books);
        $data = [
            "cash_received" => $collection->filter(function ($cashReceived) {
                return in_array($cashReceived["book_id"], [1, 9]);
            })->map(function ($cashReceived) {
            $cashReceived["journal_entries"] = collect($cashReceived["journalEntries"])->map(function ($entry) {
                $entry["journal_details"] = collect($entry["journalDetails"])->filter(function ($detail) {
                    return $detail["account_id"] == 3 && $detail["journal_details_credit"] == 0;
                })->all();
                unset($entry["journalDetails"]);
                return $entry["journal_entries"];
            })->all();
            return $cashReceived;
        })->values(),
            "cash_paid" => $collection->filter(function ($cashPaid) {
                return in_array($cashPaid["book_id"], [6, 8]);
            })->map(function ($cashPaid) {
            $cashPaid["journal_entries"] = collect($cashPaid["journalEntries"])->map(function ($entry) {
                $entry["journal_details"] = collect($entry["journalDetails"])->filter(function ($detail) {
                    return $detail["account_id"] == 3 && $detail["journal_details_debit"] == 0;
                })->all();
                unset($entry["journalDetails"]);
                return $entry["journal_entries"];
            })->all();
            return $cashPaid;
        })->values()];

        return response()->json([
            'data' => $data
        ]);

        /*         $data["cash_paid"] = collect($data["cash_paid"])->map(function ($cashPaid) {
                    $cashPaid["entries"] = collect($cashPaid["journalEntries"])->map(function ($entry) {
                        if (isset($entry["journalDetails"])) {

                            return $entry;
                        }

                    });


                    unset($cashPaid["journalEntries"]);
                    return $cashPaid;
                }); */



        /*         return AccountOfficer::leftjoin('branch','branch.branch_id','=','account_officer.branch_id')
                ->where('branch.branch_id','=',1)->get(); */

        $data = [
            'title' => 'Cashier Transaction Blotter',
            'trialbalanceList' => '',
            'cash_blotter' => CashBlotter::fetchCashBlotter(),
            'branches' => Branch::fetchBranch(),
            'account_officers' => AccountOfficer::fetchAccountOfficer(),
        ];

        return view('reports.sections.cashTransactionBlotter', $data);
    }

    public function cashBlotterIndex()
    {
        $data = CashBlotter::fetchCashBlotter();
        return response()->json([
            'data' => $data
        ]);
    }

    public function fetchAccountOfficer($id)
    {
        $ao_officer = AccountOfficer::getAccountOfficerByBranchId($id);
        return response()->json([
            'data' => $ao_officer
        ], 200);
    }

    public function storeCashBlotter(Request $request)
    {
        $cashblotter = new CashBlotter();
        $cashblotter->transaction_date = $request['transaction_date'];
        $cashblotter->total_collection = $request['totalcash_count'];
        $cashblotter->branch_id = $request['branch_id'];
        $cashblotter->save();


        $cashblotter_id = $cashblotter->cashblotter_id;

        $ao_collection = json_decode($request['ao_collection']);
        $branch_collection = json_decode($request['branch_collection']);
        $this->storeAoCollection($cashblotter_id, $ao_collection);
        $this->storeBranchCollection($cashblotter_id, $branch_collection);
        $this->storeCashBreakdown($cashblotter_id, $request);


        return response()->json([
            'success' => true,
            'message' => 'Cash Transaction Blotter created'
        ], 201);
        return response()->json(array('success' => false, 'message' => 'Something went wrong!'), 522);
    }

    public function showCashBlotter($id)
    {
    }

    public function editCashBlotter($id)
    {
        $cashblotter = CashBlotter::fetchCashBlotterById($id);
        $cash_breakdown = CashBreakdown::fetchCashBreakdownByCashblotterId($id);
        $data = [
            'cashblotter_id' => $id,
            'cash_blotter' => $cashblotter,
            'cash_breakdown' => $cash_breakdown,
            'branches' => Subsidiary::fetchBranch(),
            'account_officers' => AccountOfficer::fetchAccountOfficer(),
        ];
        if ($cash_breakdown == null) {
            return response()->json([
                'success' => false,
                'message' => 'No cash breakdown found'
            ], 422);
        } else if ($cashblotter == null) {
            return response()->json([
                'success' => false,
                'message' => 'No cash blotter found'
            ], 422);
        } else {
            return response()->json([
                'data' => $data
            ], 200);
        }
    }


    public function getEditCashBlotter($id)
    {
        $cashblotter = CashBlotter::findOrFail($id);
        return response()->json([
            'data' => $cashblotter
        ]);
    }



    private function storeAoCollection($cashblotter_id, $ao_collection)
    {
        $aocollection_data = array();
        $now = Carbon::now();
        foreach ($ao_collection as $item) {
            $aocollection_data[] = [
                'remarks' => $item->remarks,
                'total_amount' => $item->totalamount,
                'accountofficer_id' => $item->accountofficer_id,
                'cashblotter_id' => $cashblotter_id,
                'created_at' => $now,
                'updated_at' => $now,

            ];
        }
        AccountOfficerCollection::insert($aocollection_data);
    }


    private function storeBranchCollection($cashblotter_id, $branch_collection)
    {
        $aocollection_data = array();
        $now = Carbon::now();
        foreach ($branch_collection as $item) {
            $aocollection_data[] = [
                'total_amount' => $item->totalamount,
                'branch_id' => $item->branch_id,
                'cashblotter_id' => $cashblotter_id,
                'created_at' => $now,
                'updated_at' => $now,

            ];
        }
        BranchCollection::insert($aocollection_data);
    }



    private function storeCashBreakdown($cashblotter_id, $request)
    {
        $cash_breakdown = new CashBreakdown();
        $cash_breakdown->onethousand_pesos = $request['onethousand'];
        $cash_breakdown->fivehundred_pesos = $request['fivehundred'];
        $cash_breakdown->twohundred_pesos = $request['twohundred'];
        $cash_breakdown->onehundred_pesos = $request['onehundred'];
        $cash_breakdown->fifty_pesos = $request['fifty'];
        $cash_breakdown->twenty_pesos = $request['twenty'];
        $cash_breakdown->ten_pesos = $request['ten'];
        $cash_breakdown->five_pesos = $request['five'];
        $cash_breakdown->one_peso = $request['one'];
        $cash_breakdown->one_centavo = $request['centavo'];
        $cash_breakdown->total_amount = $request['totalcash_count'];
        $cash_breakdown->cashblotter_id = $cashblotter_id;

        $cash_breakdown->save();
    }


    public function cheque()
    {
        $data = [
            'title' => 'Cashier Transaction Blotter',
            'trialbalanceList' => ''
        ];
        return view('reports.sections.cheque', $data);
    }


    public function postDatedCheque()
    {
        $data = [
            'title' => 'Cashier Transaction Blotter',
            'trialbalanceList' => ''
        ];
        return view('reports.sections.postDatedCheque', $data);
    }


    public function chartOfAccounts()
    {
        $accountData = Accounts::fetch();
        $data = [
            'title' => 'Chart of Accounts',
            'accounts' => Accounts::fetch(),
            'organizedAccount' => AccountsController::groupByType($accountData),
            'account_category' => AccountCategory::get(),
            'accountTypes' => AccountType::orderBy('account_category_id')->get(),
            'cashFlows' => ['investing', 'financing', 'operating']
        ];
        return view('reports.sections.chartOfAccounts', $data);
    }

    public function reportPrint(Request $request)
    {
        $print = new PrinterController;
        switch ($request->type) {
            case 'chart_of_account':
                $print->generate_chart_of_account(AccountsController::groupByType(Accounts::fetch()), 'CHART OF ACCOUNT');
                break;
            case 'trial_balance':
                $print->generate_trial_balance($request, 'TRIAL BALANCE');
                break;
            case 'subsidiary_ledger':
                $print->subsidiary_ledger_print(Subsidiary::get(), 'SUBSIDIARY LEDGER');
                break;
            case 'general_ledger':
                $optionType = [
                    'from' => $request->from,
                    'to' => $request->to,
                    'account_name' => $request->account_name
                ];
                var_dump($optionType);
                $print->generate_general_ledger($request, 'GENERAL LEDGER');
                break;
            case 'income_statement':
                $print->generate_income_statement($request, 'INCOME STATEMENT');
                break;
            default:
        }
    }


    public function cashBlotter(Request $request)
    {
        return response()->json([
            'data' => $request
        ]);
    }

    public function journalEntry()
    {


        return 'journal entry';

    }
}
