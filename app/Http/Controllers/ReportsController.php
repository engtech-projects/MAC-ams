<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Transactions;
use App\Models\PaymentMethod;
use App\Models\Accounts;
use App\Models\TransactionType;
use App\Models\TransactionStatus;

class ReportsController extends MainController
{

	// invoice
	public function subsidiaryLedger() {

		$data = [
			'title' => 'Subsidiary Ledger',
			'subsidiaryLedgerList' => ''
		];

	   return view('reports.sections.subsidiaryledger', $data);
	}


	




	public function generalLedger()
	{
		
		$data = [
			'title' => 'General Ledger',
			'generalLedgerList' => ''
		];

	   return view('reports.sections.generalledger', $data);
	}

	public function trialBalance()
	{
		$data = [
			'title' => 'Subsidiary Ledger',
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

	    return view('reports.sections.trialBalance', $data);
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
}
