<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Models\Accounts;
use App\Models\journalEntryDetails;
use App\Models\AccountType;
use Carbon\Carbon;


class Accounts extends Model
{
    use HasFactory;

    protected $table = 'chart_of_accounts';
    protected $primaryKey = 'account_id';
    public $timestamps = true;


    const CASH_ON_HAND_ACC = 3;
    const CASH_IN_BANK_BDO_ACC = 177;
    const CASH_IN_BANK_MYB_ACC = 9;
    const PAYABLE_CHECK_ACC = 58;
    const DUE_TO_HO_BXU_BRANCH_NASIPIT_ACC = 67;

    protected $fillable = [
        'account_number',
        'account_name',
        'account_description',
        'status',
        'account_type_id',
        'parent_account',
        'bank_reconcillation'
    ];


    public function accountType()
    {
        return $this->belongsTo(AccountType::class, 'account_type_id');
    }

    public function scopeRevenueAndExpense($query, $types)
    {
        return $query->whereIn('account_category_id', $types);
    }

    public function openingBalance()
    {
        return $this->hasOne(OpeningBalance::class, 'account_id');
    }
    public function jEntries()
    {
        return $this->hasManyThrough(journalEntry::class, journalEntryDetails::class, 'account_id', 'journal_id');
    }

    public function journalEntryDetails()
    {
        return $this->hasManyThrough(journalEntryDetails::class, journalEntry::class, 'journal_id', 'account_id');
    }
    public function entries()
    {
        return $this->hasManyThrough(journalEntry::class, journalEntryDetails::class, 'account_id', 'journal_id', 'account_id', 'journal_id');
    }
    public function journalDetails()
    {
        return $this->hasMany(journalEntryDetails::class, 'journal_id', 'account_id');
    }

    public function journalEntries()
    {
        return $this->belongsToMany(journalEntry::class, 'journal_entry_details', 'journal_id', 'account_id');
    }

    public function store(array $data)
    {
        DB::beginTransaction();
        try {
            $accounting = Accounting::getFiscalYear();
            $account = self::create([
                'account_number' => $data['account_number'],
                'account_name' => $data['account_name'],
                'account_description' => $data['account_description'],
                'statement' => isset($data['statement']) ? $data['statement'] : NULL,
                'status' => 'active',
                'account_type_id' => $data['account_type_id'],
                'bank_reconcillation' => $data['bank_reconcillation'],
                'parent_account' => isset($data['parent_account']) ? $data['parent_account'] : NULL,
            ]);
            $account->openingBalance()->create([
                'opening_balance' => $data["opening_balance"],
                'starting_date' => $data['starting_date'],
                'accounting_id' => $accounting->accounting_id,
                'account_id' => $account->account_id,
            ]);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(array('error' => false, 'error_msg' => $e->getMessage(), 'message' => 'Something went wrong!'), 422);
        }
        return response()->json(array('success' => true, 'message' => 'New account created!'), 200);
    }


    public static function fetchAccountByAccountType($isJson = false)
    {
        $jsonData = [];
        $data = DB::table('chart_of_accounts')
            ->join('account_type', 'account_type.account_type_id', '=', 'chart_of_accounts.account_type_id')
            ->join('account_category', 'account_category.account_category_id', '=', 'account_type.account_category_id')
            ->select('chart_of_accounts.*', 'account_type.*', 'account_category.account_category.')
            ->where('status', 'active')
            ->orderBy('account_category.account_category_id', 'asc')
            ->orderBy('account_type.account_type_id', 'asc')
            ->get();

        if (count($data) > 0) {
            if ($isJson) {
                foreach ($data->toArray() as $key => $value) {
                    $row = [];
                    foreach ($value as $k => $v) {
                        if ($k == 'account_type') {
                            $row[$k] = utf8_encode(ucfirst($v));
                            continue;
                        }
                        $row[$k] = utf8_encode($v);
                    }
                    $jsonData['data'][] = $row;
                }
                return json_encode($jsonData);
            }
        }

        return $data;
    }


    public static function fetch($isJson = false)
    {
        $jsonData = [];
        $data = DB::table('chart_of_accounts')
            ->join('account_type', 'account_type.account_type_id', '=', 'chart_of_accounts.account_type_id')
            ->join('account_category', 'account_category.account_category_id', '=', 'account_type.account_category_id')
            ->select('chart_of_accounts.*', 'account_type.account_type', 'account_type.*', 'account_category.account_category')
            ->where(['status' => 'active'])
            ->orderBy('account_category.account_category_id', 'asc')
            ->orderBy('account_type.account_type_id', 'asc')
            ->get();

        if (count($data) > 0) {
            if ($isJson) {
                foreach ($data->toArray() as $key => $value) {
                    $row = [];
                    foreach ($value as $k => $v) {
                        if ($k == 'account_type') {
                            $row[$k] = utf8_encode(ucfirst($v));
                            continue;
                        }
                        $row[$k] = utf8_encode($v);
                    }
                    $jsonData['data'][] = $row;
                }
                return json_encode($jsonData);
            }
        }

        return $data;
    }

    public static function show($account_id)
    {
        $data = DB::table('chart_of_accounts')
            ->join('account_type', 'account_type.account_type_id', '=', 'chart_of_accounts.account_type_id')
            ->join('account_category', 'account_category.account_category_id', '=', 'account_type.account_category_id')
            ->leftJoin('opening_balance', 'chart_of_accounts.account_id', '=', 'opening_balance.account_id')
            ->select('chart_of_accounts.*', 'opening_balance.opening_balance', 'account_type.account_type', 'account_type.account_type_id', 'account_category.account_category')
            ->where('status', 'active')
            ->where('chart_of_accounts.account_id', $account_id)
            ->first();
        return $data;
    }

    public function edit(Request $request, Accounts $account)
    {

        $message = "Account successfully updated.";
        $code = 200;
        try {
            $account = self::findOrFail($account->account_id);
            $account->update($request->all());
            if ($account->openingBalance) {
                $account->openingBalance->opening_balance = $request->opening_balance;
                $account->openingBalance->save();
            } else {
                $account->openingBalance()->create([
                    'opening_balance' => $request->opening_balance,
                    'account_id' => $account->account_id,
                    'starting_date' => now()
                ]);
                $message = "Account successfully created.";
                $code = 201;
            }
        } catch (Exception $e) {
            return response()->json(array('success' => false, 'error_message' => $e->getMessage(), 'message' => 'Failed on updating Account.!'), 422);
        }
        return response()->json(array('success' => true, 'message' => $message), $code);

    }

    # function that checks transaction that is linked to a particular account.
    # fix associated transactions
    public function checkAccountLink()
    {
    }

    public function setStatus(Request $request)
    {

        $account = Accounts::find($request->id);
        $account->status = $request->status;

        if ($account->save()) {
            return response()->json(array('success' => true, 'message' => "Account has been set to $request->status"), 200);
        }
        return response()->json(array('success' => false, 'message' => 'Something went wrong!'), 200);
    }

    // public static function getAccountsBy($accountCategories = array()) {

    //     if( count($accountCategories) ) {

    //         $data = DB::table('chart_of_accounts')
    //                 ->join('account_type', 'account_type.account_type_id', '=', 'chart_of_accounts.account_type_id')
    //                 ->join('account_category', 'account_category.account_category_id', '=', 'account_type.account_category_id')
    //                 ->select('chart_of_accounts.*', 'account_type.account_type', 'account_type.account_type_id', 'account_category.account_category')
    //                 ->where('status', 'active')
    //                 ->whereIn('account_category.account_category', 'assets')
    //                 ->orderBy('account_category.account_category_id', 'asc')
    //                 ->orderBy('account_type.account_type_id', 'asc')
    //                 ->get();


    //         return $data;
    //     }

    //     return $accountCategories;
    // }

    public static function assets()
    {
        $assets = DB::table('chart_of_accounts')
            ->join('account_type', 'account_type.account_type_id', '=', 'chart_of_accounts.account_type_id')
            ->join('account_category', 'account_category.account_category_id', '=', 'account_type.account_category_id')
            ->select('chart_of_accounts.*', 'account_type.account_type', 'account_type.account_type_id', 'account_category.account_category')
            ->where('status', 'active')
            ->where('account_category.account_category', 'assets')
            ->orderBy('account_category.account_category_id', 'asc')
            ->orderBy('account_type.account_type_id', 'asc')
            ->get();

        return $assets;
    }

    public static function liabilities()
    {
        $liabilities = DB::table('chart_of_accounts')
            ->join('account_type', 'account_type.account_type_id', '=', 'chart_of_accounts.account_type_id')
            ->join('account_category', 'account_category.account_category_id', '=', 'account_type.account_category_id')
            ->select('chart_of_accounts.*', 'account_type.account_type', 'account_type.account_type_id', 'account_category.account_category')
            ->where('status', 'active')
            ->where('account_category.account_category', 'liabilities')
            ->orderBy('account_category.account_category_id', 'asc')
            ->orderBy('account_type.account_type_id', 'asc')
            ->get();

        return $liabilities;
    }

    public static function equity()
    {
        $equity = DB::table('chart_of_accounts')
            ->join('account_type', 'account_type.account_type_id', '=', 'chart_of_accounts.account_type_id')
            ->join('account_category', 'account_category.account_category_id', '=', 'account_type.account_category_id')
            ->select('chart_of_accounts.*', 'account_type.account_type', 'account_type.account_type_id', 'account_category.account_category')
            ->where('status', 'active')
            ->where('account_category.account_category', 'equity')
            ->orderBy('account_category.account_category_id', 'asc')
            ->orderBy('account_type.account_type_id', 'asc')
            ->get();

        return $equity;
    }

    public static function income()
    {
        $income = DB::table('chart_of_accounts')
            ->join('account_type', 'account_type.account_type_id', '=', 'chart_of_accounts.account_type_id')
            ->join('account_category', 'account_category.account_category_id', '=', 'account_type.account_category_id')
            ->select('chart_of_accounts.*', 'account_type.account_type', 'account_type.account_type_id', 'account_category.account_category')
            ->where('status', 'active')
            ->where('account_category.account_category', 'income')
            ->orderBy('account_category.account_category_id', 'asc')
            ->orderBy('account_type.account_type_id', 'asc')
            ->get();

        return $income;
    }

    public static function expense()
    {
        $expense = DB::table('chart_of_accounts')
            ->join('account_type', 'account_type.account_type_id', '=', 'chart_of_accounts.account_type_id')
            ->join('account_category', 'account_category.account_category_id', '=', 'account_type.account_category_id')
            ->select('chart_of_accounts.*', 'account_type.account_type', 'account_type.account_type_id', 'account_category.account_category')
            ->where('status', 'active')
            ->where('account_category.account_category', 'expense')
            ->orderBy('account_category.account_category_id', 'asc')
            ->orderBy('account_type.account_type_id', 'asc')
            ->get();

        return $expense;
    }
    public static function getTrialBalance($from = '', $to = '', $account_id = '')
    {
        $query = DB::table("chart_of_accounts")
            ->select(DB::raw("chart_of_accounts.account_name,
                    chart_of_accounts.account_number    ,
                    SUM(journal_entry_details.journal_details_debit) as total_debit ,
                    SUM(journal_entry_details.journal_details_credit) as total_credit"))
            ->join("journal_entry_details", function ($join) {
                $join->on("chart_of_accounts.account_id", "=", "journal_entry_details.account_id");
            })
            ->join("journal_entry", function ($join) {
                $join->on("journal_entry_details.journal_id", "=", "journal_entry.journal_id");
            });

        $query->groupBy("chart_of_accounts.account_id");
        return $query->get();
    }
    //gerneralLedger (All Account)
    public static function generalLedger_fetchAccounts($from = '', $to = '', $account_id = '')
    {
        $journalEntries = JournalEntry::join('journal_book', 'journal_entry.book_id', '=', 'journal_book.book_id')
            ->join('journal_entry_details', 'journal_entry_details.journal_id', '=', 'journal_entry.journal_id')
            ->join('chart_of_accounts', 'journal_entry_details.account_id', '=', 'chart_of_accounts.account_id')
            ->join('subsidiary', 'journal_entry_details.subsidiary_id', '=', 'subsidiary.sub_id')
            ->join('account_type', 'account_type.account_type_id', '=', 'chart_of_accounts.account_type_id')
            ->join('account_category', 'account_category.account_category_id', '=', 'account_type.account_category_id')
            ->leftJoin('opening_balance', 'chart_of_accounts.account_id', '=', 'opening_balance.account_id')
            ->select(
                'account_category.account_category',
                'account_category.to_increase',
                'account_type.account_type',
                'chart_of_accounts.account_id',
                'chart_of_accounts.account_number',
                'chart_of_accounts.account_name',
                'opening_balance.opening_balance',
                'subsidiary.sub_name',
                'journal_entry.journal_date',
                'journal_entry.journal_no',
                'journal_entry.source',
                'journal_entry.cheque_no',
                'journal_entry.cheque_date',
                'journal_entry_details.journal_id',
                'journal_entry_details.journal_details_id',
                'journal_entry_details.journal_details_debit',
                'journal_entry_details.journal_details_credit',
            );

        if ($from != '' && $to != '') {
            $journalEntries->whereBetween("journal_entry.journal_date", [$from, $to]);
        }
        if ($account_id != '') {
            $journalEntries->where('chart_of_accounts.account_id', $account_id);
        }

        return $journalEntries->orderBy('chart_of_accounts.account_number', 'ASC')
            ->orderBy('journal_entry.journal_date', 'ASC')
            ->orderBy('journal_entry_details.journal_id', 'ASC')
            ->get();
    }

    public static function subsidiaryLedger($from = '', $to = '', $account_id = '', $subsidiary_id = '') {

        $query = Subsidiary::select(
                            'subsidiary.sub_id',
                            'subsidiary.sub_name',
                            'subsidiary.sub_code'
                        );

        if ($subsidiary_id != '') {
            $query->where('subsidiary.sub_id', $subsidiary_id);
        }

        $subsidiaries = $query->get()->toArray();
        $subLedger = [];

        foreach ($subsidiaries as $subsidiary) {

            $entries = [];
            $data = [];

            $journalEntries = JournalEntry::join('journal_book', 'journal_entry.book_id', '=', 'journal_book.book_id')
                                    ->join('journal_entry_details', 'journal_entry_details.journal_id', '=', 'journal_entry.journal_id')
                                    ->join('chart_of_accounts', 'journal_entry_details.account_id', '=', 'chart_of_accounts.account_id')
                                    ->join('subsidiary', 'journal_entry_details.subsidiary_id', '=', 'subsidiary.sub_id')
                                    ->join('account_type', 'account_type.account_type_id', '=', 'chart_of_accounts.account_type_id')
                                    ->join('account_category', 'account_category.account_category_id', '=', 'account_type.account_category_id')
                                    ->leftJoin('opening_balance', 'chart_of_accounts.account_id', '=', 'opening_balance.account_id')
                                    ->select(
                                        'account_category.account_category',
                                        'account_category.to_increase',
                                        'account_type.account_type',
                                        'chart_of_accounts.account_id',
                                        'chart_of_accounts.account_number',
                                        'chart_of_accounts.account_name',
                                        'opening_balance.opening_balance',
                                        'subsidiary.sub_name',
                                        'journal_entry.journal_date',
                                        'journal_entry.journal_no',
                                        'journal_entry.source',
                                        'journal_entry.cheque_no',
                                        'journal_entry.cheque_date',
                                        'journal_entry.remarks',
                                        'journal_entry.payee',
                                        'journal_entry_details.journal_id',
                                        'journal_entry_details.subsidiary_id',
                                        'journal_entry_details.journal_details_id',
                                        'journal_entry_details.journal_details_debit',
                                        'journal_entry_details.journal_details_credit',
                                    );

                                if ($from != '' && $to != '') {
                                    $journalEntries->whereBetween("journal_entry.journal_date", [$from, $to]);
                                }

                                if ($account_id != '') {
                                    $journalEntries->where('chart_of_accounts.account_id', $account_id);
                                }

                                $journalEntries->where('journal_entry_details.subsidiary_id', $subsidiary['sub_id']);

            $data =  $journalEntries->orderBy('chart_of_accounts.account_number', 'ASC')
                                ->orderBy('journal_entry.journal_date', 'ASC')
                                ->orderBy('journal_entry_details.journal_id', 'ASC')
                                ->get()->toArray();

            if( count($data) > 0 ) {

                foreach ($data as $key => $value) {

                    if( !array_key_exists($value['account_number'], $entries) )  {

                        $entries[$value['account_number']]['account_id'] = $value['account_id'];
                        $entries[$value['account_number']]['account_number'] = $value['account_number'];
                        $entries[$value['account_number']]['account_name'] = $value['account_name'];
                        $entries[$value['account_number']]['to_increase'] = $value['to_increase'];
                        $entries[$value['account_number']]['opening_balance'] = $value['opening_balance'];

                        $entries[$value['account_number']]['data'][] = [
                            'sub_name' => $value['sub_name'],
                            'journal_date' => $value['journal_date'],
                            'journal_no' => $value['journal_no'],
                            'payee' => $value['payee'],
							'remarks' => $value['remarks'],
                            'source' => $value['source'],
                            'cheque_no' =>$value['cheque_no'],
                            'cheque_date' => $value['cheque_date'],
                            'journal_id' =>$value['journal_id'],
                            'debit' => $value['journal_details_debit'],
                            'credit' => $value['journal_details_credit'],
                        ];
                    }else{
                        $entries[$value['account_number']]['data'][] = [
                            'sub_name' => $value['sub_name'],
                            'journal_date' => $value['journal_date'],
                            'journal_no' => $value['journal_no'],
                            'payee' => $value['payee'],
							'remarks' => $value['remarks'],
                            'source' => $value['source'],
                            'cheque_no' =>$value['cheque_no'],
                            'cheque_date' => $value['cheque_date'],
                            'journal_id' =>$value['journal_id'],
                            'debit' => $value['journal_details_debit'],
                            'credit' => $value['journal_details_credit'],
                        ];
                   }

                }

                foreach ($entries as $key => $entry) {

                    $balance = 0;
                    $balance = $entry['opening_balance'];

                    foreach ($entry['data'] as $k => $v) {

                        if( $entry['to_increase'] == 'debit' ){
                            $balance += $v['debit'];
                            $balance -= $v['credit'];
                        }

                        if( $entry['to_increase'] == 'credit' ) {
                            $balance += $v['credit'];
                            $balance -= $v['debit'];
                        }

                        $entries[$key]['data'][$k]['balance'] = $balance;
                    }
                }


                $subLedger[] = [
                    'sub_id' => $subsidiary['sub_id'],
                    'sub_code' => $subsidiary['sub_code'],
                    'sub_name' => $subsidiary['sub_name'],
                    'entries' => $entries
                ];
            }

        }

         return $subLedger;
    }


    public function getRevenueAndExpense($filter)
    {
        $accountsJournalEntries = collect();
        journalEntryDetails::from('journal_entry_details as detail')
            ->select([
                'detail.journal_id',
                'entry.journal_no',
                'entry.journal_date',
                'entry.source',
                'entry.cheque_no',
                'entry.cheque_date',
                'detail.journal_details_debit',
                'detail.journal_details_credit',
                'account.account_number',
                'account.account_id',
                'account.account_name',
                'acc_categ.account_category',
                'detail.subsidiary_id',
                'sub.sub_name',
                'branch.branch_name',
                'acc_type.account_no as account_type_no',
                'acc_categ.account_category_id',
                'acc_categ.to_increase'

            ])
            ->join('chart_of_accounts as account', 'account.account_id', '=', 'detail.account_id')
            ->join('account_type as acc_type', 'acc_type.account_type_id', 'account.account_type_id')
            ->join('account_category as acc_categ', 'acc_categ.account_category_id', '=', 'acc_type.account_category_id')
            ->join('journal_entry as entry', 'entry.journal_id', '=', 'detail.journal_id')
            ->join('subsidiary as sub', 'sub.sub_id', '=', 'detail.subsidiary_id')
            ->join('branch', 'branch.branch_id', '=', 'entry.branch_id')
            ->whereIn('acc_categ.account_category_id', [4, 5])
            ->orderBy('entry.journal_id', 'desc')
            ->where('detail.subsidiary_id', $filter["subsidiary_id"])
            ->whereBetween("entry.journal_date", [$filter["date_from"], $filter["date_to"]])
            ->chunk(500, function (Collection $items) use (&$accountsJournalEntries) {
                foreach ($items as $item) {
                    $accountsJournalEntries->push($item);
                }
            });
        $accountsJournalEntries = $this->mapRevenueMinusExpenseCollection($accountsJournalEntries);

        return $accountsJournalEntries;
    }

    public function mapRevenueMinusExpenseCollection($accountsJournalEntries)
    {
        $accountsJournalEntries = collect($accountsJournalEntries)->groupBy(function ($groupCategory) {
            return $groupCategory["account_category"];
        })->map(function ($accounts) use ($accountsJournalEntries) {
            $groupAccounts = collect($accounts)->map(function ($account) use ($accountsJournalEntries) {
                $groupAccounts = [
                    "account_id" => $account["account_id"],
                    "account_name" => $account["account_name"],
                    "account_category" => $account["account_category"],
                    "account_category_id" => $account["account_category_id"],
                ];
                $groupAccounts["entries"] = collect($accountsJournalEntries)->filter(function ($item) use (&$groupAccounts) {
                    $filteredAccounts = $item["account_id"] === $groupAccounts["account_id"];
                    return $filteredAccounts;
                })->map(function ($item, $category) {
                    $details = [
                        "journal_id" => $item["journal_id"],
                        "journal_no" => $item["journal_no"],
                        "journal_date" => $item["journal_date"],
                        "cheque_no" => $item["cheque_date"],
                        "cheque_date" => $item["cheque_no"],
                        "account_id" => $item["account_id"],
                        "source" => $item["source"],
                        "subsidiary_id" => $item["subsidiary_id"],
                        "subsidiary_name" => $item["sub_name"],
                        "branch" => $item["branch_name"],
                        "to_increase" => $item["to_increase"],
                        "credit" => $item["journal_details_credit"],
                        "debit" => $item["journal_details_debit"]

                    ];
                    return $details;
                })->filter(function ($item) {
                    if ($item["to_increase"] === "credit") {
                        return $item["credit"] > 0;
                    } else {
                        return $item["debit"] > 0;
                    }
                })->filter()->values();
                return $groupAccounts;
            })->unique()->values();
            return $groupAccounts;
        })->map(function ($item) {
            $accounts = collect($item)->map(function ($item) {
                if (count($item["entries"]) > 0) {
                    return $item;
                } else {
                    unset($item);
                }
            })->filter()->values();
            return $accounts;
        });

        return $accountsJournalEntries;
    }

    public function getAccountBalance($from, $to, $account_id) {

        $cycle = Accounting::getFiscalYear(1);
        $startDate = Carbon::parse($cycle->start_date);
        $fromDate = Carbon::parse($from);
        $toDate = Carbon::parse($to);
        $diff = $startDate->diffInDays($fromDate);
        $endDate = Carbon::parse($fromDate->toDateString())->subDay(1);

        $balance = $this->getOpeningBalance($account_id);

        if( $diff > 0 ) {

            $account = Accounts::join('journal_entry_details as jed', 'coa.account_id', '=', 'jed.account_id')
                        ->join('journal_entry as je', 'jed.journal_id', '=', 'je.journal_id')
                        ->select(
                            'coa.account_id',
                            'coa.account_number',
                            'coa.account_name',
                            DB::raw('COALESCE(SUM(jed.journal_details_debit)) AS total_debit'),
                            DB::raw('COALESCE(SUM(jed.journal_details_credit)) AS total_credit')
                        )
                        ->from('chart_of_accounts as coa')
                        ->where(['coa.type' => 'L', 'coa.account_id' => $account_id ])
                        ->whereBetween("je.journal_date", [$startDate->toDateString(), $endDate->toDateString()])
                        ->groupBy('coa.account_id','coa.account_number','coa.account_name')
                        ->first();


            if( $account ){
                return $balance + $account->total_debit - $account->total_credit;    
            }
        }

        return $balance;
    }

    public function getOpeningBalance($account_id) {

        $obj = OpeningBalance::where(['account_id' => $account_id])->first('opening_balance');

        if( $obj && isset($obj->opening_balance) ) {
            return $obj->opening_balance;
        }

        return 0;
    }

    public function ledger($range = [], $account_id = '') {

        $account = Accounts::join('journal_entry_details as jed', 'coa.account_id', '=', 'jed.account_id')
                        ->join('journal_entry as je', 'jed.journal_id', '=', 'je.journal_id')
                        ->join('subsidiary as sub', 'jed.subsidiary_id', '=', 'sub.sub_id')
                        ->join('account_type as at', 'at.account_type_id', '=', 'coa.account_type_id')
                        ->join('account_category as ac', 'ac.account_category_id', '=', 'at.account_category_id')
                        ->select(
                            'ac.account_category','ac.to_increase',
                            'at.account_type',
                            'coa.account_id', 'coa.account_number', 'coa.account_name',
                            'je.journal_date','je.journal_no','je.source', 'je.cheque_no','je.cheque_date', 'je.payee', 'je.remarks',
                            'jed.journal_details_debit','jed.journal_details_credit',
                            'sub.sub_name',
                            'ac.account_category','ac.to_increase'
                        )
                        ->from('chart_of_accounts as coa')
                        ->where(['je.status' => 'posted', 'coa.type' => 'L', 'coa.status' => 'active'])
                        ->whereBetween("je.journal_date", $range);

        if( $account_id ) {
            $account->where(['coa.account_id' => $account_id]);
        }

        $data = $account->orderBy('je.journal_date', 'ASC')
                        ->orderBy('jed.journal_id', 'ASC')
                        ->get();

        $ledger = [];

        $current_balance = 0;
        $total_debit = 0;
        $total_credit = 0;

        foreach ($data as $key => $value) {
            
            if( !isset($ledger[$value->account_id]) ) {

                $balance = $this->getAccountBalance($range[0], $range[1], $value->account_id);
                $current_balance = $balance;
                $total_debit = 0;
                $total_credit = 0;

                $ledger[$value->account_id] = [
                    'account_category' => $value->account_category,
                    'account_type' => $value->account_type,
                    'account_number' => $value->account_number,
                    'account_name' => $value->account_name,
                    'balance' => number_format($balance, 2),
                    'current_balance' => 0,
                    'total_debit' => 0,
                    'total_credit' => 0,
                    'to_increase' => $value->to_increase,
                    'entries' => []
                ];
            }

            $current_balance += ($value->journal_details_debit - $value->journal_details_credit);
            $total_debit += $value->journal_details_debit;
            $total_credit += $value->journal_details_credit;

            $ledger[$value->account_id]['current_balance'] = number_format($current_balance, 2);
            $ledger[$value->account_id]['total_debit'] = number_format($total_debit, 2);
            $ledger[$value->account_id]['total_credit'] = number_format($total_credit, 2);

            $ledger[$value->account_id]['entries'][] = [
                'sub_name' => $value->sub_name,
                'journal_date' => Carbon::parse($value->journal_date)->format('m/d/y'),
                'journal_no' => $value->journal_no,
                'source' => $value->source,
                'cheque_no' => $value->cheque_no ,
                'cheque_date' => ($value->cheque_date) ? Carbon::parse($value->cheque_date)->format('m/d/y') : NULL,
                'debit' => number_format($value->journal_details_debit, 2),
                'credit' => number_format($value->journal_details_credit, 2),
                'current_balance' => number_format($current_balance, 2),
                'payee' => $value->payee,
                'remarks' => $value->remarks
            ];
        }

        return $ledger;
    }

}
