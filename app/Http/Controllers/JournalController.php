<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Hash;
use Session;
use DB;
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
use App\Models\Accounting;
use Carbon\Carbon;

class JournalController extends MainController
{
    public function index()
    {
        $this->journalEntry();
    }
    public function create()
    {
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
    public function store(Request $request)
    {
        return $request;
    }
    public function journalEntry(Request $request)
    {
        $data = [
            'title' => 'MAC-AMS | Journal Entry',
            'journalBooks' => JournalBook::getBookWithJournalCount(),
            'subsidiaries' => Subsidiary::with(['subsidiaryCategory'])->orderBy('sub_cat_id', 'ASC')->get(),
            'chartOfAccount' => Accounts::whereIn('type', ['L', 'R'])->where(['status' => 'active'])->get()
        ];

        return view('journal.sections.journalEntry', $data);
    }

    public function saveJournalEntry(journalEntry $journalEntry, Request $request)
    {
        try {
            $journalEntry = $journalEntry->createJournalEntry($request->input());
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
        }

        return response()->json([
            'message' => 'Journal Entry successfully saved.',
        ], 201);
    }
    public function JournalEntryFetch(Request $request)
    {
        $journalEntry = JournalEntry::with(['bookDetails',  'journalEntryDetails','journalEntryDetails.account','branch','journalEntryDetails.subsidiary'])->where('journal_id', $request->journal_id)->get();
        return response()->json(['message' => 'fetch', 'data' => $journalEntry]);

        //return json_encode(['message' => 'fetch', 'data' => JournalEntry::with(['bookDetails', 'journalEntryDetails'])->where('journal_id', $request->journal_id)->get()]);
    }
    public function JournalEntryCancel(Request $request)
    {
        $journal = JournalEntry::find($request->id);
        $journal->status = 'cancelled';
        if ($journal->save()) {
            return response()->json(['message' => $journal->status]);
        }
        return response()->json(['message' => 'error']);
    }
    public function JournalEntryEdit(Request $request)
    {
        $journal = JournalEntry::find($request->journal_entry['edit_journal_id']);
        DB::transaction(function() use($request, $journal){
            $journal->journal_no = $request->journal_entry['edit_journal_no'];
            $journal->journal_date = $request->journal_entry['edit_journal_date'];
            $journal->branch_id = $request->journal_entry['edit_branch_id'];
            $journal->book_id = $request->journal_entry['edit_book_id'];
            $journal->source = $request->journal_entry['edit_source'];
            $journal->cheque_no = $request->journal_entry['edit_cheque_no'];
            $journal->cheque_date = $request->journal_entry['edit_cheque_date'];
            $journal->amount = $request->journal_entry['edit_amount'];
            $journal->status = $request->journal_entry['edit_status'];
            $journal->payee = $request->journal_entry['edit_payee'];
            $journal->remarks = $request->journal_entry['edit_remarks'];
            $journal->save();
            $journal->details()->delete();
            $journal->details()->createMany($request->details);
        });
        $journal->refresh();
        return json_encode(['message' => 'update', 'id' => $journal->journal_id]);
    }

    public function JournalEntryPostUnpost(Request $request)
    {
        $journal = JournalEntry::find($request->journal_id);

        // Toggle the status between 'posted' and 'unposted'
        $journal->status = ($journal->status === 'posted') ? 'unposted' : 'posted';

        if ($journal->save()) {
            return response()->json(['message' => $journal->status]);
        }
        
        return response()->json(['message' => 'error']);
    }
    public function searchJournalEntry(Request $request)
    {   
        // Fetch journal entries
        $journalEntries = JournalEntry::fetch(
            $request->s_status,
            $request->s_from,
            $request->s_to,
            $request->s_book_id,
            $request->s_branch_id
        );

        // Append branch name to each journal entry
        foreach ($journalEntries as $entry) {
            $entry->branch_name = $entry->branch->branch_name;
        }

        // Return JSON response with journal entries including branch name
        return response()->json($journalEntries);
    }
    public function journalEntryList(Request $request)
    {   
        $accounting = Accounting::getFiscalYear();
        $current_date = Carbon::now();

        $data = [
            'title' => 'MAC-AMS | Journal Entry List',
            'journalBooks' => JournalBook::get(),
            'subsidiaries' => Subsidiary::with(['subsidiaryCategory'])->orderBy('sub_cat_id', 'ASC')->get(),
            'journalEntryList' => JournalEntry::fetch('posted', $current_date->toDateString(), $current_date->toDateString()),
            'chartOfAccount' => Accounts::whereIn('type', ['L', 'R'])->where(['status' => 'active'])->get(),
            'default_date_start' => $current_date->toDateString()
        ];
        // return response()->json(['data' => $data]); 

        // echo '<pre>';
        // var_export($current_date->toDateString());
        // echo '</pre>';
        return view('journal.sections.journalEntryList', $data);
    }
    public function show($id)
    {
    }
    public function populate()
    {
    }

}
