<?php

namespace App\Http\Controllers;

use Hash;
use Session;
use Exception;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Accounts;
use App\Models\Customer;
use App\Models\Employee;
use App\Models\Supplier;
use App\Models\Accounting;
use App\Models\Subsidiary;
use App\Models\AccountType;
use App\Models\JournalBook;
use App\Models\journalEntry;
use App\Models\Transactions;
use Illuminate\Http\Request;
use App\Models\PostingPeriod;
use App\Models\TransactionType;
use Illuminate\Validation\Rule;
use App\Models\TransactionStatus;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\LogOptions;
use App\Models\journalEntryDetails;
use Illuminate\Support\Facades\Auth;

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
        $request->validate([
            'journal_entry.journal_date' => 'required|date'
        ]);
        $period = new PostingPeriod();
        $open_periods = $period->openStatus()->get();
        if (count($open_periods) >= 1) {
            $matchFound = false;
            foreach ($open_periods as $open) {
                $journal_date = $request->journal_entry['journal_date'];
                $isOpen = $period->isInPostingPeriod($journal_date, $open);
                if ($isOpen) {
                    $created = $journalEntry->createJournalEntry($request->input());
                    if ($created) {
                        activity("Journal Entry")->event("created")->performedOn($journalEntry)
                            ->log("Journal Entry - Create");
                        $matchFound = true;
                    }
                }
            }
            if (!$matchFound) {
                return response()->json([
                    'message' => 'Unable to proceed transaction, posting period and status is not open for this entry',
                ], 400);
            }
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
        $replicate = $journal->replicate();

        try {
            DB::transaction(function () use ($journal, $replicate) {
                $updated = $journal->update([
                    'journal_status' => 'cancelled'
                ]);
                if ($updated) {
                    $changes = getChanges($journal, $replicate);
                    activity("Journal Entry List")->event("updated")->performedOn($journal)
                        ->withProperties(['attributes' => $changes['attributes'], 'old' => $changes['old']])
                        ->log("Journal Entry - Cancel");
                }
            });
        } catch (\Exception $e) {
            return new JsonResponse([
                'message' => 'Transaction Failed.',
                'error' => $e->getMessage()
            ], JsonResponse::HTTP_BAD_REQUEST);
        }
        return new JsonResponse([
            'message' => 'Successfully updated.',
        ], JsonResponse::HTTP_OK);
    }
    public function JournalEntryEdit(Request $request)
    {

        $journalEntry = JournalEntry::findOrFail($request->journal_entry['edit_journal_id']);
        $replicate = $journalEntry->replicate();

        $period = new PostingPeriod();
        $open_periods = $period->openStatus()->get();


        if (count($open_periods) < 1) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot update journal entry - no posting periods are currently open.',
            ], 403);
        }


        if (count($open_periods) >= 1) {
            $matchFound = false;
            foreach ($open_periods as $open) {
                $journal_date = $request->journal_entry['journal_date'];
                $isOpen = $period->isInPostingPeriod($journal_date, $open);
                if ($isOpen) {
                    try {
                        DB::transaction(function () use ($request, $journalEntry, $replicate) {
                            $amount = preg_replace('/[₱,]/', '', $request->journal_entry['edit_amount']);
                            $amount = fmod((float)$amount, 1) == 0 ? (int)$amount : number_format((float)$amount, 2, '.', '');
                            $updated = $journalEntry->update([
                                'journal_no' => $request->journal_entry['edit_journal_no'],
                                'journal_date' => $request->journal_entry['journal_date'],
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
                            $journalEntry->details()->delete();
                            $journalEntry->details()->createMany($request->details);
                            if ($updated) {
                                $changes = getChanges($journalEntry, $replicate);
                                activity("Journal Entry List")->event("updated")->performedOn($journalEntry)
                                    ->withProperties(['attributes' => $changes['attributes'], 'old' => $changes['old']])
                                    ->log("Journal Entry - Update");
                            }
                        });
                        $matchFound = true;
                    } catch (Exception $e) {
                        return new JsonResponse([
                            'message' => 'Transaction Failed.',
                            'error' => $e->getMessage()
                        ], JsonResponse::HTTP_BAD_REQUEST);
                    }
                }
            }
            if (!$matchFound) {
                return new JsonResponse([
                    'message' => 'Unable to proceed transaction, posting period and status is not open for this entry',
                    'error' => $e->getMessage(),
                    'success' => false
                ], JsonResponse::HTTP_BAD_REQUEST);
            }
        }
        return response()->json([
            'message' => 'Journal Entry updated successfully.',
            'success' => true,
        ], 200);
    }

    public function JournalEntryPostUnpost(Request $request)
    {

        $journal = JournalEntry::find($request->journal_id);
        $replicate = $journal->replicate();

        // Toggle the status between 'posted' and 'unposted'
        $status = $journal->status == 'posted' ? 'unposted' : 'posted';
        $journal->update([
            'status' => $status
        ]);
        if ($journal) {
            $log_prefix = $journal->getChanges()['status'] = 'posted' ? 'Post' : 'Unpost';
            activity("Journal Entry List")->event("updated")->performedOn($journal)
                ->withProperties(['attributes' => $journal, 'old' => $replicate])
                ->log("Journal Entry - " . ucfirst($journal->status));
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
    public function show($id) {}
    public function populate() {}
}
