<?php

namespace App\Http\Controllers;

use App\Http\Requests\BankReconciliationReportsRequest;
use App\Http\Requests\RevenueMinusExpenseRequest;
use App\Models\CollectionBreakdown;
use App\Models\User;
use Illuminate\Http\JsonResponse;
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
use Illuminate\Support\Facades\Auth;
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
        $from = $request->from ? $request->from : $accounting->default_start;
        $to = $request->to ? $request->to : $accounting->default_end;
        // $from = $request->from ? $request->from : $accounting->start_date;
        // $to = $request->to ? $request->to : $accounting->end_date;
        $branch_id = $request->branch_id ? $request->branch_id : '';
        $status = $request->status ? $request->status : null;
        $book_id = $request->book_id ? $request->book_id : '';
        $journal_no = $request->journal_no ? $request->journal_no : '';
        $journal_source = $request->journal_source ? $request->journal_source : '';
        $journal_payee = $request->journal_payee ? $request->journal_payee : '';

        // $branch = Branch::find($branch_id);
        $journal_entry = journalEntry::fetch($status, $from, $to, $book_id, $branch_id, 'ASC', $journal_no, $journal_source, $journal_payee);
        $journal_ledger = [];

        $page = [];
        foreach ($journal_entry as $entry) {

            $entries = [];

            foreach ($entry->details as $details) {
                $subsidiary = null;

                if ($details->subsidiary_id) {
                    $subsidiary = Subsidiary::select('sub_name')->where(['sub_id' => $details->subsidiary_id])->first();
                }

                $entries[] = [
                    'account' => $details->journal_details_account_no,
                    'title' => $details->journal_details_title,
                    'subsidiary' => $subsidiary ? $subsidiary->sub_name : null,
                    'debit' => $details->journal_details_debit,
                    'credit' => $details->journal_details_credit
                ];
            }

            $entry->reference_name = '';
            $branch = Branch::find($entry->branch_id);

            if ($branch) {
                $entry->reference_name = $branch->branch_name;
            }

            $entryDate = null;
            $entryDate = Carbon::parse($entry->journal_date)->format('m/d/Y');

            if (!in_array($entry->journal_date, $page)) {
                $page[] = $entry->journal_date;
            }


            $journal_ledger[] = [
                'date' => $entryDate,
                'page' => (array_search($entry->journal_date, $page) + 1),
                'reference' => $entry->journal_no,
                'source' => $entry->source,
                'reference_name' => $entry->reference_name,
                'remarks' => $entry->remarks,
                'status' => $entry->status,
                'details' => $entries
            ];
        }

        // $currentPage = $request->page ? $request->page : 1;

        /* ----- end journal ledger ----- */
        // $paginated = $this->paginate($journal_ledger, $currentPage);

        // echo '<pre>';
        // var_export($journal_ledger);
        // echo '</pre>';

        $data = [
            'title' => 'MAC-AMS | Journal Ledger',
            'journalBooks' => JournalBook::getBookWithJournalCount(),
            'jLedger' => $journal_ledger,
            // 'paginated' => $paginated,
            'requests' => ['from' => $from, 'to' => $to],
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
            'title' => 'MAC-AMS | Subsidiary Ledger',
            'subsidiaryLedgerList' => '',
            'accounts' => Accounts::all()
        ];

        return view('reports.sections.subsidiaryledger', $data);
    }

    public function monthlyDepreciation(Request $request)
    {

        $branches = Branch::all();
        $date = explode("-", $request->sub_date);

        $subsidiary = new Subsidiary();
        $branch = Branch::find($request->branch_id);
        $result = $subsidiary->getDepreciation($request->sub_cat_id, $branch, $date);

        $data = $result->map(function ($value) use ($branch) {
            if ($value->sub_no_depre == 0) {
                $value->sub_no_depre = 1;
            }
            $branch = Branch::where('branch_code', $value->sub_per_branch)->first();
            $monthlyAmort = $value->sub_amount / $value->sub_no_depre;
            $value['branch'] = $branch->branch_code . '-' . $branch->branch_name;
            $value['monthly_amort'] = $monthlyAmort;
            $value['expensed'] = round($value->sub_no_amort * $monthlyAmort, 2);
            $value['unexpensed'] = round($value->sub_amount - $value->expensed);
            $value['due_amort'] = round($value->sub_no_amort, 2);

            $value['rem'] = round($value->sub_no_depre - $value->sub_no_amort, 2);
            $value['inv'] = 0;
            $value['no'] = 0;
            return $value;
        })->groupBy('branch')->map(function ($item) {
            /*      $item['total_expensed'] = $item->sum('expensed'); */


            return [
                'subsidiaries' => $item,
                'branch_total_amount' => round($item->sum('sub_amount'), 2),
                'branch_total_amort' => round($item->sum('sub_no_depre'), 2),
                'branch_total_monthly' => round($item->sum('monthly_amort'), 2),
                'branch_total_expensed' => round($item->sum('expensed'), 2),
                'branch_total_unexpensed' => round($item->sum('unexpensed'), 2),
                'branch_total_amort_monthly' => round($item->sum('monthly_amort'), 2),
                'branch_total_used' => round($item->sum('sub_no_amort'), 2),
                'branch_total_due_amort' => round($item->sum('due_amort'), 2),
                'branch_total_sub_salvage' => round($item->sum('sub_salvage'), 2),
                'branch_total_rem' => round($item->sum('rem'), 2)
            ];
        })/* ->map(function ($item,) {
            $item = collect($item);
            $grand = [
                'grand_total_amount' => round($item->sum($item['branch_total_amount']), 2),
                'grand_total_amort' => round($item->sum('branch_total_amort'), 2),
                'grand_total_monthly' => round($item->sum('branch_total_monthly'), 2),
                'grand_total_expensed' => round($item->sum('branch_total_expensed'), 2),
                'grand_total_unexpensed' => round($item->sum('branch_total_unexpensed'), 2),
                'grand_total_amort_monthly' => round($item->sum('branch_total_amort_monthly'), 2),
                'grand_total_used' => round($item->sum('branch_total_used'), 2),
                'grand_total_due_amort' => round($item->sum('branch_total_due_amort'), 2),
                'grand_total_sub_salvage' => round($item->sum('branch_total_sub_salvage'), 2),
                'grand_total_rem' => round($item->sum('branch_total_rem'), 2)
            ];
            $item['grand'] = $grand;
            return $item;
        }) */->all();

        $data = [
            'data' => $data,
            'subsidiary_categories' => SubsidiaryCategory::where('sub_cat_type', 'depre')->get(),
            'branches' => $branches,
            'title' => 'MAC-AMS | Monthly Depreciation',
        ];
        return view('reports.sections.monthlyDepreciation', $data);
        return response()->json([
            'data' => $data,
            'message' => 'Successfully Fetched'
        ]);
    }


    public function subsidiaryLedgerReports(Request $request)
    {
        $filter = $request->input();
        $data = [
            'subsidiaryData' => Subsidiary::get(),
            'sub_categories' => SubsidiaryCategory::get(),
            'title' => 'MAC-AMS | Subsidiary Ledger',
            'subsidiaryLedgerList' => '',
            'accounts' => Accounts::all(),
        ];
        switch ($filter["type"]) {
            case 'subsidiary-ledger-listing-report':

                $journalEntry = new journalEntry();
                $subsidiaryListing = $journalEntry->getSubsidiaryListing($filter);
                return response()->json(['data' => $subsidiaryListing]);

            case 'income_minus_expense':
                $revenueMinusExpenseReport = $this->revenueMinusExpense($filter);
                return response()->json(['data' => $revenueMinusExpenseReport]);

            case 'subsidiary_all_account':

                $transactions = Accounts::subsidiaryLedger($request->from, $request->to, '', $request->subsidiary_id);
                return response()->json(['data' => $transactions]);

            case 'subsidiary_per_account':
                $glAccounts = new Accounts();
                $transactions = $glAccounts->ledger([$filter['from'], $filter['to']], $filter['account_id'], $filter['subsidiary_id']);

                $ss = Accounts::subsidiaryLedger($filter['from'], $filter['to'], $filter['account_id'], $filter['subsidiary_id']);
                $balance = Accounts::getSubsidiaryAccountBalance($filter['from'], $filter['to'], $filter['account_id'], $filter['subsidiary_id']);

                return response()->json(['data' => [$ss, $balance]]);


            case 'subsidiary-ledger':
                return view('reports.sections.subsidiaryledger', $data);
        }
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
            $sub->sub_code = $request->sub_acct_no;
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

        $glAccounts = new Accounts();
        $accounting = Accounting::getFiscalYear();

        $from = $request->from ? $request->from : $accounting->default_start;
        $to = $request->to ? $request->to : $accounting->default_end;
        $account_id = !$request->account_id ? 3 : $request->account_id;

        $transactions = $glAccounts->ledger([$from, $to], $account_id);
        $accounts = Accounts::whereIn('type', ['L', 'R'])->where(['status' => 'active'])->get();

        $data = [
            'title' => 'MAC-AMS | General Ledger',
            'chartOfAccount' => $accounts,
            'requests' => ['from' => $from, 'to' => $to, 'account_id' => $account_id],
            'fiscalYear' => $accounting,
            'transactions' => $transactions,
        ];

        return view('reports.sections.generalledger', $data);
    }


    public function trialBalance(Request $request)
    {
        $accounts = [];
        $acc = new Accounts();
        $fiscalYear = Accounting::getFiscalyear();
        $tDate =  $request->input("date") ? new Carbon($request->input("date")) : Carbon::parse(TransactionDate::get_date());
        $accounts = $acc->getTrialBalance([$fiscalYear->start_date, $tDate]);
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
            'transactionDate' => $tDate->toDateString(),
        ];
        return view('reports.sections.trialBalance', $data);
    }


    public function bankReconcillation(Request $request)
    {
        $data = [

            'chartOfAccount' => \App\Models\Accounts::where(['type' => 'L'])->get(),
            'title' => 'MAC-AMS | Bank Reconciliation',
            'trialbalanceList' => ''
        ];


        return view('reports.sections.bankReconcillation', $data);
    }

    public function cashPosition()
    {
        $data = [
            'title' => 'MAC-AMS | Cash Position',
            'trialbalanceList' => ''
        ];

        return view('reports.sections.cashPosition', $data);
    }

    public function cashTransactionBlotter(Request $request)
    {

        $now = Carbon::now();
        $transactionDate = $request["transaction_date"] ? $request["transaction_date"] : $now->toDateString();

        $branchId = session()->get("auth_user_branch");
        $data = [
            'title' => 'MAC-AMS | Cashiers Transaction Blotter',
            'trialbalanceList' => '',
            'cash_blotter' => CollectionBreakdown::getCollectionBreakdownByBranch($transactionDate, $branchId),
            'branches' => Branch::fetchBranch(),
            'account_officers' => AccountOfficer::fetchAccountOfficer(),
        ];
        return view('reports.sections.cashTransactionBlotter', $data);
    }

    public function searchCashTransactionBlotter(Request $request)
    {
        $transactionDate = $request["transaction_date"];
        $branch = Branch::find($request->branch_id);
        $branchId = session()->get("auth_user_branch");
        if (isset($request->branch_id)) {
            $branchId = $request->branch_id;
        }
        $collections = CollectionBreakdown::getCollectionBreakdownByBranch($transactionDate, $branchId);
        $message = $collections->count() > 0 ? "Collections fetched." : "No record found.";
        return response()->json(['message' => $message, 'data' => [
            'collections' => $collections,
            'branch' => $branch
        ]]);
    }

    public function showCashTransactionBlotter($id, Request $request)
    {

        $journalEntries = new journalEntry();
        $cashTransactionsEntries = $journalEntries->getCashBlotterEntries($id, $request->branch_id);
        return response()->json($cashTransactionsEntries);
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
            'message' => 'Cashiers Transaction Blotter created'
        ], 201);
    }

    public function showCashBlotter($id, Request $request)
    {

        $journalEntries = new journalEntry();
        $cashTransactionsEntries = $journalEntries->getCashBlotterEntries($id, $request->branch_id);
        return response()->json([
            'entries' => $cashTransactionsEntries
        ], 200);
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

    public function revenueMinusExpense(array $filter)
    {
        $accounts = new Accounts();
        $data = $accounts->getRevenueAndExpense($filter);
        return $data;
    }


    public function bankReconciliation(BankReconciliationReportsRequest $request)
    {
        $journalEntryModel = new journalEntry();

        $data = $journalEntryModel->getBankReconciliationReport($request->validated());

        return $data;
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

    public function balanceSheet(Request $request)
    {

        $coa = new Accounts();
        $accounting = Accounting::getFiscalYear();

        $from = $accounting->start_date;
        // $from = '2024-02-01';
        // $to = '2024-02-01';

        $now = Carbon::now();
        $to =  $request->input("date") ? new Carbon($request->input("date")) : $now;
        $balanceSheet = $coa->balanceSheet([$from, $to]);
        // $currentEarnings = $coa->currentEarnings([$from, $to]);

        // echo '<pre>';
        // var_export($balanceSheet);
        // echo '</pre>';

        $data = [
            'title' => 'MAC-AMS | Balance Sheet',
            'requests' => ['from' => $from, 'to' => $to],
            'fiscalYear' => $accounting,
            'balanceSheet' => $balanceSheet,
            'current_date' => $to->toDateString(),
            // 'currentEarnings' => $currentEarnings
        ];

        return view('reports.sections.balanceSheet', $data);
    }

    public function incomeStatement(Request $request)
    {

        $coa = new Accounts();
        $accounting = Accounting::getFiscalYear();

        $from = isset($request->from) ? $request->from : $accounting->start_date;
        $to = isset($request->to) ? $request->to : $accounting->end_date;

        $incomeStatement = $coa->incomeStatement([$from, $to]);

        $data = [
            'title' => 'MAC-AMS | Income Statement',
            'requests' => ['from' => $from, 'to' => $to],
            'fiscalYear' => $accounting,
            'incomeStatement' => $incomeStatement,
            'from' => $from,
            'to' => $to
        ];

        return view('reports.sections.incomeStatement', $data);
    }
}
