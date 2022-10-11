<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Transactions;
use App\Models\PaymentMethod;
use App\Models\Accounts;
use App\Models\AccountCategory;
use App\Models\AccountType;
use App\Models\TransactionType;
use App\Models\TransactionStatus;
use App\Models\Subsidiary;
use App\Models\SubsidiaryCategory;
use App\Http\Controllers\PrinterController;
use App\Http\Controllers\AccountsController;

class ReportsController extends MainController
{
	// invoice
	public function subsidiaryLedger() {

		$data = [
			'subsidiaryData'=> Subsidiary::get(),
			'sub_categories' => SubsidiaryCategory::get(),
			'title' => 'Subsidiary Ledger',
			'subsidiaryLedgerList' => ''
		];	
		
	    return view('reports.sections.subsidiaryledger', $data);
		
	}
	public function subsidiarySaveorEdit(Request $request)
	{	
		if($request->sub_id == '')
		{
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
			if($sub->save())
			{
				return json_encode(['message' => 'save', 'sub_id'=> $sub->sub_id]);
			}
		}else{
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
			if($sub->save())
			{
				return json_encode(['message' => 'update', 'sub_id'=> $sub->sub_id]);
			}
		}
		return false;
	}
	public function generalLedgerFetchAccount(Request $request)
	{
		if($request->id != '')
		{
			$id = $request->id;
			$genLedgerFrom = $request->genLedgerFrom;
			$genLedgerTo = $request->genLedgerTo;
			return json_encode(Accounts::generalLedger_fetchAccounts($genLedgerFrom, $genLedgerTo, $id));
		}else{
			return json_encode(Accounts::generalLedger_fetchAccounts());
		}
	}
	public function subsidiaryViewInfo(Request $request)
	{
		$data = Subsidiary::where('sub_id',$request->id)->get();
		if(count($data) > 0){
			return json_encode($data);
		}
		return false;
	}
	public function subsidiaryDelete(Request $request)
	{
		if(Subsidiary::find($request->id)->delete()){
			return json_encode(['message' => 'delete', 'sub_id'=> $request->sub_id]);
		}
		return false;
	}
	public function generalLedger()
	{
		$data = [
			'title' => 'General Ledger',
			'chartOfAccount'=> Accounts::get(),
			'generalLedgerAccounts' => Accounts::generalLedger_fetchAccounts()
		];
		return view('reports.sections.generalledger', $data);
	}
	public function trialBalance()
	{
		$data = [
			'title' => 'Subsidiary Ledger',
			'trialBalance'=> Accounts::getTrialBalance(),
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
		$data = [
			'title' => 'Cashier Transaction Blotter',
			'trialbalanceList' => ''
		];

	    return view('reports.sections.cashTransactionBlotter', $data);
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
			'organizedAccount'=> AccountsController::groupByType($accountData),
			'account_category'=> AccountCategory::get(),
			'accountTypes' => AccountType::orderBy('account_category_id')->get(),
            'cashFlows'    => ['investing', 'financing', 'operating'] 
        ];
    	return view('reports.sections.chartOfAccounts', $data);
	}

	public function reportPrint(Request $request)
	{
		$print = new PrinterController;
		switch($request->type){
			case 'chart_of_account':
				$print->generate_chart_of_account(AccountsController::groupByType(Accounts::fetch()),'CHART OF ACCOUNT');
				break;
			case 'trial_balance':
				$print->generate_trial_balance($request,'TRIAL BALANCE');
				break;
			case 'subsidiary_ledger':
				$print->subsidiary_ledger_print(Subsidiary::get(),'SUBSIDIARY LEDGER');
				break;
			case 'general_ledger':
				$optionType = [
					'from'=> $request->from,
					'to'=> $request->to,
					'account_name'=>$request->account_name
				];
				var_dump($optionType);
				$print->generate_general_ledger($request,'GENERAL LEDGER');
				break;
			case 'income_statement':
				$print->generate_income_statement($request,'INCOME STATEMENT');
				break;
			default:
				
		}
		
	}
}
