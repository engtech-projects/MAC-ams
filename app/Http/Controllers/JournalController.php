<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Hash;
use Session;
use DB;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
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

    public function generateJournalNumber(JournalBook $journalBook)
    {
        $journalNumber = $journalBook->generateJournalNumber();
        return response()->json(['data' => $journalNumber]);
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
            'subsidiaries' => Subsidiary::with(['subsidiary_category'])->orderBy('sub_cat_id', 'ASC')->get(),
            'chartOfAccount' => Accounts::whereIn('type', ['L', 'R'])->where(['status' => 'active'])->get()
        ];

        return view('journal.sections.journalEntry', $data);
    }

    public function saveJournalEntry(journalEntry $journalEntry, Request $request)
    {
        // // Define custom validation messages
        // $customMessages = [
        //     'journal_entry.journal_no.unique' => 'The reference number has already been taken.',
        // ];

        // // Validate the request data
        // $request->validate([
        //     'journal_entry.journal_no' => 'required|unique:journal_entry,journal_no',
        // ], $customMessages);

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
        $journalEntry = JournalEntry::with(['bookDetails',  'journalEntryDetails', 'journalEntryDetails.account', 'branch', 'journalEntryDetails.subsidiary'])->where('journal_id', $request->journal_id)->get();
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
        // // Define custom validation messages
        // $customMessages = [
        //     'journal_entry.edit_journal_no.unique' => 'The reference number has already been taken.',
        //     'journal_entry.edit_journal_no.required' => 'The reference number is required.',
        // ];

        // // Validate the request data
        // $request->validate([
        //     'journal_entry.edit_journal_no' => [
        //         'required',
        //         Rule::unique('journal_entry', 'journal_no')->ignore($request->journal_entry['edit_journal_id'], 'journal_id')
        //     ],
        // ], $customMessages);

        // Retrieve the existing journal entry
        $journalEntry = JournalEntry::findOrFail($request->journal_entry['edit_journal_id']);

        try {
            // Update the journal entry with the provided data
            DB::transaction(function () use ($request, $journalEntry) {
                $amount = preg_replace('/[₱,]/', '', $request->journal_entry['edit_amount']);
                $amount = fmod((float)$amount, 1) == 0 ? (int)$amount : number_format((float)$amount, 2, '.', '');

                $journalEntry->update([
                    'journal_no' => $request->journal_entry['edit_journal_no'],
                    'journal_date' => $request->journal_entry['edit_journal_date'],
                    'branch_id' => $request->journal_entry['edit_branch_id'],
                    'book_id' => $request->journal_entry['edit_book_id'],
                    'source' => $request->journal_entry['edit_source'],
                    'cheque_no' => $request->journal_entry['edit_cheque_no'],
                    'cheque_date' => $request->journal_entry['edit_cheque_date'],
                    'amount' => $amount,
                    'status' => $request->journal_entry['edit_status'],
                    'payee' => $request->journal_entry['edit_payee'],
                    'remarks' => $request->journal_entry['edit_remarks'],
                ]);

                // Update journal entry details
                $journalEntry->details()->delete();
                $journalEntry->details()->createMany($request->details);
            });

        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }

        return response()->json([
            'message' => 'Journal Entry updated successfully.',
        ], 200);
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
            $request->s_branch_id,
        );

        // Append branch name to each journal entry
        foreach ($journalEntries as $entry) {
            if ($entry->branch) {
                $entry->branch_name = $entry->branch->branch_name;
            } else {
                $entry->branch_name = null;
            }
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
            'subsidiaries' => Subsidiary::with(['subsidiary_category'])->orderBy('sub_cat_id', 'ASC')->get(),
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
