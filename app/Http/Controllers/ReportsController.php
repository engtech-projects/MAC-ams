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
use App\Repositories\Reports\ReportsRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ReportsController extends MainController
{


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
            $sub  = Subsidiary::find($request->sub_id);
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
            $ledger = $this->calculateRunningBalance($journalEntries);
            return json_encode($journalEntries);


        } else {

            $journalEntries = Accounts::generalLedger_fetchAccounts();
            $ledger = $this->calculateRunningBalance($journalEntries,'','');
            return json_encode($ledger);

        }


    }
    public function calculateRunningBalance($data) {
            $balance = 0;
            foreach ($data as $transaction) {
                $balance += $transaction->journal_details_debit;
                $balance -= $transaction->journal_details_credit;

            }
            return $data;
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
    public function generalLedger()
    {

            $journalEntries = Accounts::generalLedger_fetchAccounts();
            $transactions = $this->calculateRunningBalance($journalEntries);
            $data = [
                'title' => 'General Ledger',
                'chartOfAccount' => Accounts::get(),
                'generalLedgerAccounts' => Accounts::generalLedger_fetchAccounts(),
                'transactions' => $transactions,
            ];
            return view('reports.sections.generalledger', $data);

    }


    public function trialBalance()
    {
        $data = [
            'title' => 'Subsidiary Ledger',
            'trialBalance' => Accounts::getTrialBalance(),
            'trialbalanceList' => ''
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
        return view('reports.sections.trialBalance', $data);
    }
    public function cashPosition()
    {
        $data = [
            'title' => 'Subsidiary Ledger',
            'trialbalanceList' => ''
        ];

        return view('reports.sections.trialBalance', $data);
    }
    public function cashTransactionBlotter()
    {

        /* return AccountOfficer::leftjoin('branch','branch.branch_id','=','account_officer.branch_id')
        ->where('branch.branch_id','=',1)->get(); */


        $data = [
            'title' => 'Cashier Transaction Blotter',
            'trialbalanceList' => '',
            'cash_blotter'  => CashBlotter::fetchCashBlotter(),
            'branches' => Branch::fetchBranch(),
            'account_officers'      =>      AccountOfficer::fetchAccountOfficer(),
        ];

        return view('reports.sections.cashTransactionBlotter', $data);
    }
    public function cashBlotterIndex()
    {
        $data = CashBlotter::fetchCashBlotter();
        return response()->json([
            'data'      =>      $data
        ]);
    }

    public function fetchAccountOfficer($id)
    {
        $ao_officer = AccountOfficer::getAccountOfficerByBranchId($id);
        return response()->json([
            'data'      =>      $ao_officer
        ], 200);
    }

    public function storeCashBlotter(Request $request)
    {
        $cashblotter = new CashBlotter();
        $cashblotter->transaction_date      =   $request['transaction_date'];
        $cashblotter->total_collection      =   $request['totalcash_count'];
        $cashblotter->branch_id             =   $request['branch_id'];
        $cashblotter->save();


        $cashblotter_id = $cashblotter->cashblotter_id;

        $ao_collection =  json_decode($request['ao_collection']);
        $branch_collection  = json_decode($request['branch_collection']);
        $this->storeAoCollection($cashblotter_id, $ao_collection);
        $this->storeBranchCollection($cashblotter_id, $branch_collection);
        $this->storeCashBreakdown($cashblotter_id, $request);


        return response()->json([
            'success'       =>      true,
            'message'       =>      'Cash Transaction Blotter created'
        ], 201);
        return response()->json(array('success' => false, 'message' => 'Something went wrong!'), 522);
    }

    public function showCashBlotter($id)
    {
    }



    public function editCashBlotter($id)
    {
        $cashblotter = CashBlotter::fetchCashBlotterById($id);
        $cash_breakdown =  CashBreakdown::fetchCashBreakdownByCashblotterId($id);
        $data = [
            'cashblotter_id'        =>      $id,
            'cash_blotter'           =>      $cashblotter,
            'cash_breakdown'         =>      $cash_breakdown,
            'branches'              =>      Subsidiary::fetchBranch(),
            'account_officers'      =>      AccountOfficer::fetchAccountOfficer(),
        ];
        if ($cash_breakdown == null) {
            return response()->json([
                'success'       =>      false,
                'message'       =>      'No cash breakdown found'
            ], 422);
        } else if ($cashblotter   ==   null) {
            return response()->json([
                'success'       =>      false,
                'message'       =>      'No cash blotter found'
            ], 422);
        } else {
            return response()->json([
                'data'      =>      $data
            ], 200);
        }
    }


    public function getEditCashBlotter($id)
    {
        $cashblotter = CashBlotter::findOrFail($id);
        return response()->json([
            'data'      =>      $cashblotter
        ]);
    }



    private function storeAoCollection($cashblotter_id, $ao_collection)
    {
        $aocollection_data = array();
        $now = Carbon::now();
        foreach ($ao_collection as $item) {
            $aocollection_data[] = [
                'remarks'               =>  $item->remarks,
                'total_amount'          =>  $item->totalamount,
                'accountofficer_id'     =>  $item->accountofficer_id,
                'cashblotter_id'        =>  $cashblotter_id,
                'created_at'            =>  $now,
                'updated_at'            =>  $now,

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
                'total_amount'          =>  $item->totalamount,
                'branch_id'             =>  $item->branch_id,
                'cashblotter_id'        =>  $cashblotter_id,
                'created_at'            =>  $now,
                'updated_at'            =>  $now,

            ];
        }
        BranchCollection::insert($aocollection_data);
    }



    private function storeCashBreakdown($cashblotter_id, $request)
    {
        $cash_breakdown = new CashBreakdown();
        $cash_breakdown->onethousand_pesos      =       $request['onethousand'];
        $cash_breakdown->fivehundred_pesos      =       $request['fivehundred'];
        $cash_breakdown->twohundred_pesos       =       $request['twohundred'];
        $cash_breakdown->onehundred_pesos       =       $request['onehundred'];
        $cash_breakdown->fifty_pesos            =       $request['fifty'];
        $cash_breakdown->twenty_pesos           =       $request['twenty'];
        $cash_breakdown->ten_pesos              =       $request['ten'];
        $cash_breakdown->five_pesos             =       $request['five'];
        $cash_breakdown->one_peso               =       $request['one'];
        $cash_breakdown->one_centavo            =       $request['centavo'];
        $cash_breakdown->total_amount           =       $request['totalcash_count'];
        $cash_breakdown->cashblotter_id         =       $cashblotter_id;

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
            'cashFlows'    => ['investing', 'financing', 'operating']
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
}
