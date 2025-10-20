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
                        $created->load('details');
                        activity("Journal Entry")->event("created")->performedOn($created)
                            ->withProperties(['model_snapshot' => $created->toArray()])
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
        $journal->load('details');
        $replicate = $journal->replicate();

        try {
            DB::transaction(function () use ($journal, $replicate) {
                $journal->update(['status' => 'cancelled']);
                $changes = getChanges($journal, $replicate);
                unset($changes['attributes']['updated_at'], $changes['old']['updated_at']);
                if (!empty($changes['attributes'])) {
                    activity("Journal Entry List")->event("updated")->performedOn($journal)
                        ->withProperties([
                            'model_snapshot' => $journal->toArray(),
                            'attributes' => $changes['attributes'], 
                            'old' => $changes['old']
                        ])
                        ->log("Journal Entry - Cancel");
                }
            });
            return new JsonResponse([
                'message' => 'cancelled',
            ], JsonResponse::HTTP_OK);
        } catch (\Exception $e) {
            return new JsonResponse([
                'message' => 'Transaction Failed.',
                'error' => $e->getMessage()
            ], JsonResponse::HTTP_BAD_REQUEST);
        }
    }
    public function JournalEntryEdit(Request $request)
    {

        $journalEntry = JournalEntry::findOrFail($request->journal_entry['edit_journal_id']);
        $journalEntry->load('details');
        $replicate = $journalEntry->replicate();
        $sourcePage = $request->input('journal_entry.source_page', 'unknown');
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
                        DB::transaction(function () use ($request, $journalEntry, $replicate, $sourcePage) {
                            $amount = preg_replace('/[₱,]/', '', $request->journal_entry['edit_amount']);
                            $amount = fmod((float)$amount, 1) == 0 ? (int)$amount : number_format((float)$amount, 2, '.', '');
                            $oldDetails = collect($journalEntry->details->toArray())->map(function($detail) {
                                unset($detail['id'], $detail['journal_details_id'], $detail['created_at'], $detail['updated_at']);
                                return $detail;
                            })->toArray();
                            $journalEntry->update([
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
                            $journalEntry->load('details');
                            $newDetails = collect($journalEntry->details->toArray())->map(function($detail) {
                                unset($detail['id'], $detail['journal_details_id'], $detail['created_at'], $detail['updated_at']);
                                return $detail;
                            })->toArray();
                            $changes = getChanges($journalEntry, $replicate);
                            unset($changes['attributes']['updated_at'], $changes['old']['updated_at']);
                            if (json_encode($oldDetails) !== json_encode($newDetails)) {
                                $changes['old']['details'] = $oldDetails;
                                $changes['attributes']['details'] = $newDetails;
                            }
                            if (!empty($changes['attributes'])) {
                                activity($sourcePage)->event("updated")->performedOn($journalEntry)
                                    ->withProperties([
                                        'model_snapshot' => $journalEntry->toArray(),
                                        'attributes' => $changes['attributes'], 
                                        'old' => $changes['old']
                                    ])
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
        $journal->load('details');
        $replicate = $journal->replicate();
        $newStatus = $journal->status == 'posted' ? 'unposted' : 'posted';
        $logAction = $newStatus == 'posted' ? 'Post' : 'Unpost';
        try {
            DB::transaction(function () use ($journal, $replicate, $newStatus, $logAction) {
                $journal->update(['status' => $newStatus]);
                $changes = getChanges($journal, $replicate);
                unset($changes['attributes']['updated_at'], $changes['old']['updated_at']);
                if (!empty($changes['attributes'])) {
                    activity("Journal Entry List")->event("updated")->performedOn($journal)
                        ->withProperties([
                            'model_snapshot' => $journal->toArray(),
                            'attributes' => $changes['attributes'], 
                            'old' => $changes['old']
                        ])
                        ->log("Journal Entry - " . $logAction);
                }
            });
            
            return response()->json(['message' => $newStatus]);
            
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'error',
                'error' => $e->getMessage()
            ], 500);
        }
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
