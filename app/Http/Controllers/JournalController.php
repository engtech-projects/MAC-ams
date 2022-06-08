<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Hash;
use Session;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\AccountType;
use App\Models\Accounts;
use App\Models\Supplier;
use App\Models\Customer;
use App\Models\Employee;
use App\Models\Transactions;
use App\Models\TransactionType;
use App\Models\TransactionStatus;
use App\Models\JournalBook;

class JournalController extends MainController
{
   
   public function index() {}   

 	public function create() {

 		$transactionType = TransactionType::where('transaction_type', 'journal')->first();

 		$data = [
 			'title' => 'Journal Entry',
 			'customers' => Customer::all(),
 			'suppliers' => Supplier::all(),
 			'employees' => Employee::all(),
 			'assets' => Accounts::assets(),
 			'liabilities' => Accounts::liabilities(),
 			'equity' => Accounts::equity(),
 			'income' => Accounts::income(),
 			'expenses' => Accounts::expense(),
 			'transactionType' => $transactionType
 		];

 		return view('journal.createjournal', $data);

 	}

 	public function store(Request $request) {

 		return $request;

 	}

	public function journalEntry(Request $request)
	{
		$data = [
			'title' => 'Journal Entry',
			'journalBooks' => JournalBook::get(),
		];

	    return view('journal.sections.journalEntry', $data);
	}

	public function journalEntryList(Request $request)
	{
		$data = [
			'title' => 'Journal Entry List',
			'journalEntryList' => ''
		];

	    return view('journal.sections.journalEntryList', $data);
	}

 	public function show($id) {}
 	public function populate() {}

}
