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
use App\Models\Subsidiary;
use App\Models\JournalBook;
use App\Models\journalEntry;
use App\Models\journalEntryDetails;

class JournalController extends MainController
{

	public function index() {
		$this->journalEntry();
	}   
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
			'subsidiaries' => Subsidiary::with(['subsidiaryCategory'])->orderBy('sub_cat_id', 'ASC')->get(),
			'chartOfAccount' => Accounts::get()
		];

	    return view('journal.sections.journalEntry', $data);
	}

	public function saveJournalEntry(Request $request)
	{
		$journal_no = 0;
		$id = journalEntry::orderBy('journal_id','DESC')->take(1)->pluck('journal_id');
		if(count($id) > 0){
			$journal_no = '1'.sprintf("%006s",$id[0]);
		}
	
		$journal = new journalEntry;
		$journal->journal_no = $journal_no;
		$journal->journal_date = $request->journal_date;
		$journal->branch_id = $request->branch_id;
		$journal->book_id = $request->book_id;
		$journal->source = $request->source;
		$journal->cheque_no = $request->cheque_no;
		$journal->cheque_date = $request->cheque_date;
		$journal->amount = $request->amount;
		$journal->status = $request->status;
		$journal->payee = $request->payee;
		$journal->remarks = $request->remarks;
		$journal->save();
		return json_encode(['message'=>'save','id'=> $journal->journal_id]);
	}

	public function saveJournalEntryDetails(Request $request)
	{
		if(journalEntryDetails::insert($request->items))
		{
			return json_encode(['message'=>'save']);
		}
	}
	public function JournalEntryFetch(Request $request)
	{
		return json_encode(['message'=>'fetch','data'=> JournalEntry::with(['journalDetails.chartOfAccount','bookDetails', 'journalDetails.subsidiary'])->where('journal_id', $request->journal_id)->get()]);
	}
	public function JournalEntryDelete(Request $request)
	{
		$journal = JournalEntry::find($request->journal_id);
		
		if($journal->delete())
		{
			return json_encode(['message'=> 'delete']);
		}
		return json_encode(['message'=> 'error']);
	}

	public function JournalEntryEdit(Request $request)
	{
		//$request->$journal_id;
		$journal = JournalEntry::find($request->journal_id);
		$journal->journal_no = $request->journal_no;
		$journal->journal_date = $request->journal_date;
		$journal->branch_id = $request->branch_id;
		$journal->book_id = $request->book_id;
		$journal->source = $request->source;
		$journal->cheque_no = $request->cheque_no;
		$journal->cheque_date = $request->cheque_date;
		$journal->amount = $request->amount;
		$journal->status = $request->status;
		$journal->payee = $request->payee;
		$journal->remarks = $request->remarks;
		if($journal->save())
		{
			return json_encode(['message'=> 'update']);
		}
		return json_encode(['message'=> 'error']);
	}
	
	public function JournalEntryPostUnpost(Request $request)
	{
		$journal = JournalEntry::find($request->journal_id);
		$journal->status = 'posted';
		if($journal->save())
		{
			return json_encode(['message'=> $journal->status]);
		}
		return json_encode(['message'=> 'error']);
	}
	
	
	public function searchJournalEntry(Request $request)
	{
		return json_encode(JournalEntry::fetch($request->s_status,
			$request->s_from,
			$request->s_to,
			$request->s_book_id,
			$request->s_branch_id));
	}

	public function journalEntryList(Request $request)
	{
		$data = [
			'title' => 'Journal Entry',
			'journalBooks' => JournalBook::get(),
			'subsidiaries' => Subsidiary::with(['subsidiaryCategory'])->orderBy('sub_cat_id', 'ASC')->get(),
			'journalEntryList' => JournalEntry::fetch(),
			'chartOfAccount' => Accounts::get()
		];

	    return view('journal.sections.journalEntryList', $data);
	}

 	public function show($id) {}
 	public function populate() {}

}
