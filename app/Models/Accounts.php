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
use Illuminate\Database\Eloquent\Builder;

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
    public function checkAccountLink() {}

    public function setStatus(Request $request)
    {

        $account = Accounts::find($request->id);
        $account->status = $request->status;

        if ($account->save()) {
            return response()->json(array('success' => true, 'message' => "Account has been set to $request->status"), 200);
        }
        return response()->json(array('success' => false, 'message' => 'Something went wrong!'), 200);
    }

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
            ->where('account_category.account_category', 'revenue')
            ->whereIn('chart_of_accounts.type', ['L', 'R', 'X'])
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
    public function getTrialBalance($range = [])
    {
        $accounts = Accounts::join('account_type as at', 'at.account_type_id', '=', 'coa.account_type_id')
            ->join('account_category as ac', 'ac.account_category_id', '=', 'at.account_category_id')
            ->select(
                'ac.account_category',
                'ac.account_category_id',
                'ac.to_increase',
                'at.account_type',
                'at.account_type_id',
                'coa.account_id',
                'coa.account_number',
                'coa.account_name',
            )
            ->from('chart_of_accounts as coa')
            ->where(['coa.status' => 'active'])
            ->whereIn('coa.type', ['L', 'R', 'X'])
            ->orderBy('coa.account_number', 'ASC')
            ->groupBy('coa.account_id')
            ->get();

        $sheet = [
            'accounts' => [],
            'total_asset' => 0
        ];

        foreach ($accounts as $account) {

            $data = journalEntry::leftJoin('journal_entry_details as jed', 'je.journal_id', '=', 'jed.journal_id')
                ->select(
                    DB::raw('SUM(jed.journal_details_debit) as debit'),
                    DB::raw('SUM(jed.journal_details_credit) as credit'),
                    DB::raw('(SUM(jed.journal_details_debit) - SUM(jed.journal_details_credit)) as total'),
                )
                ->from('journal_entry as je')
                ->whereBetween("je.journal_date", $range)
                ->where(['jed.account_id' => $account->account_id, 'je.status' => 'posted'])
                ->groupBy('jed.account_id')
                ->groupBy('jed.journal_details_account_no')
                ->limit(1)
                ->first();

            if ($data) {
                $account->debit = $data['debit'];
                $account->credit = $data['credit'];
                $account->total = $data['total'];
            } else {

                // account id of Current Earnings
                if ($account->account_id == 84) {
                    $account->debit = 0;
                    $account->credit = 0;
                    $account->total = $this->currentEarnings($range);
                } else {
                    $account->debit = 0;
                    $account->credit = 0;
                    $account->total = 0;
                }
            }

            // ------------------------------------------------------------------------

            if (!isset($sheet['accounts'][$account->account_category])) {
                $sheet['accounts'][$account->account_category] = [
                    'total' => 0,
                    'types' => []
                ];
            }

            if (!isset($sheet['accounts'][$account->account_category]['types'][$account->account_type_id])) {
                $sheet['accounts'][$account->account_category]['types'][$account->account_type_id] = [
                    'total' => 0,
                    'name' => $account->account_type,
                    'accounts' => []

                ];
            } else {
            }
            // $opening_balance = in_array($account->account_category, ["revenue", "expense"]) && $account->debit == 0 && $account->credit == 0 ? 0 : $this->getAccountBalance($range[0], $range[1], $account->account_id);
            $opening_balance = $this->getAccountBalance($range[0], $range[1], $account->account_id);

            if (isset($account->to_increase) && strtolower($account->to_increase) == 'debit') {
                $subtotal = ($account->total + $opening_balance);
            } else {
                $subtotal = abs($account->total - $opening_balance);
                // if( $account->total >= 0 ) {
                //    $subtotal = abs($account->total + $opening_balance);
                // }else{
                //     $subtotal = abs($account->total + ($opening_balance) * -1);
                // }


            }

            $sheet['accounts'][$account->account_category]['types'][$account->account_type_id]['accounts'][$account->account_id] = [
                'account_number' => $account->account_number,
                'account_name' => $account->account_name,
                'debit' =>  $account->debit,
                'credit' => $account->credit,
                'opening_balance' => $opening_balance,
                'total' => $subtotal,
                'computed' => $subtotal
            ];

            $sheet['accounts'][$account->account_category]['types'][$account->account_type_id]['total'] += $sheet['accounts'][$account->account_category]['types'][$account->account_type_id]['accounts'][$account->account_id]['computed'];

            $sheet['accounts'][$account->account_category]['total'] += $sheet['accounts'][$account->account_category]['types'][$account->account_type_id]['accounts'][$account->account_id]['computed'];
        }

        $sheet['total_asset'] = [
            'title' => 'TOTAL LIABILITIES AND EQUITY',
            'value' => ($sheet['accounts']['liabilities']['total'] + $sheet['accounts']['equity']['total'])
        ];

        return $sheet;
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
                'jounal_entry.journal_id',
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

    public static function getSubsidiaryOpenningBalance($from, $account_id, $subsidiary_id)
    {
        $accounting = Accounting::where('status', 'open')->first();
        $opening_balance = SubsidiaryOpeningBalance::where('account_id', $account_id)->where('sub_id', $subsidiary_id)->first();
        $entries = JournalEntry::with(['details' => function ($query) use ($subsidiary_id, $account_id) {
            $query->where('subsidiary_id', $subsidiary_id)->where('account_id', $account_id);
        }])->posted()
            ->whereDate('journal_date', '<', $from)
            ->get();

        $entries->map(function ($item) {
            $item['total_credit'] = $item->details->sum('journal_details_credit');
            $item['total_debit'] = $item->details->sum('journal_details_debit');
            return $item;
        });
        $debit = 0;
        $credit = 0;
        foreach ($entries as $val) {
            $credit += $val['total_credit'];
            $debit += $val['total_debit'];
        }
        $total = ($opening_balance->opening_balance + $debit) - $credit;
        return $opening_balance->opening_balance;
    }


    public static function subsidiaryLedger($from = '', $to = '', $account_id = '', $subsidiary_id = '')
    {

        $balance = SubsidiaryOpeningBalance::where(['account_id' => $account_id, 'sub_id' => $subsidiary_id])->first();

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
                /* ->leftJoin('opening_balance', 'chart_of_accounts.account_id', '=', 'opening_balance.account_id') */
                /* ->join('subsidiary_opening_balance', 'subsidiary_opening_balance.sub_id', '=', 'subsidiary.sub_id') */
                ->join('branch', 'journal_entry.branch_id', '=', 'branch.branch_id') // Join with branch table
                ->with(['subsidiary_opening_balance' => function ($query) use ($subsidiary_id) {
                    $query->where('sub_id', $subsidiary_id);
                }])
                // ->where(["journal_entry.status" => "posted"])
                ->select(
                    'account_category.account_category',
                    'account_category.to_increase',
                    'account_type.account_type',
                    'chart_of_accounts.account_id',
                    'chart_of_accounts.account_number',
                    'chart_of_accounts.account_name',
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
                    'branch.branch_name'

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
            if (count($data) > 0) {

                foreach ($data as $key => $value) {

                    if (!array_key_exists($value['account_number'], $entries)) {


                        $entries[$value['account_number']]['account_id'] = $value['account_id'];
                        $entries[$value['account_number']]['account_number'] = $value['account_number'];
                        $entries[$value['account_number']]['account_name'] = $value['account_name'];
                        $entries[$value['account_number']]['to_increase'] = $value['to_increase'];
                        $entries[$value['account_number']]['opening_balance'] = is_null($value['subsidiary_opening_balance']) ? 0 : $value['subsidiary_opening_balance']['opening_balance'];

                        $entries[$value['account_number']]['data'][] = [
                            'sub_name' => $value['sub_name'],
                            'journal_date' => $value['journal_date'],
                            'journal_no' => $value['journal_no'],
                            'payee' => $value['payee'],
                            'remarks' => $value['remarks'],
                            'source' => $value['source'],
                            'cheque_no' => $value['cheque_no'],
                            'cheque_date' => $value['cheque_date'],
                            'journal_id' => $value['journal_id'],
                            'debit' => $value['journal_details_debit'],
                            'credit' => $value['journal_details_credit'],
                            'branch' => $value['branch_name'],
                        ];
                    } else {
                        $entries[$value['account_number']]['data'][] = [
                            'sub_name' => $value['sub_name'],
                            'journal_date' => $value['journal_date'],
                            'journal_no' => $value['journal_no'],
                            'payee' => $value['payee'],
                            'remarks' => $value['remarks'],
                            'source' => $value['source'],
                            'cheque_no' => $value['cheque_no'],
                            'cheque_date' => $value['cheque_date'],
                            'journal_id' => $value['journal_id'],
                            'debit' => $value['journal_details_debit'],
                            'credit' => $value['journal_details_credit'],
                            'branch' => $value['branch_name'],
                        ];
                    }
                }

                foreach ($entries as $key => $entry) {

                    $balance = 0;
                    $balance = $entry['opening_balance'];

                    foreach ($entry['data'] as $k => $v) {


                        if ($entry['to_increase'] == 'debit') {
                            $balance += $v['debit'];
                            $balance -= $v['credit'];
                        }

                        if ($entry['to_increase'] == 'credit') {
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
    public static function getSubsidiaryAccountBalance($from, $to, $account_id, $subsidiary_id)
    {

        $cycle = Accounting::getFiscalYear(1);
        $startDate = Carbon::parse($cycle->start_date);
        $fromDate = Carbon::parse($from);
        $toDate = Carbon::parse($to);
        $diff = $startDate->diffInDays($fromDate);
        $endDate = Carbon::parse($fromDate->toDateString())->subDay(1);
        $opening_balance = SubsidiaryOpeningBalance::where('account_id', $account_id)->where('sub_id', $subsidiary_id)->first();
        if ($opening_balance) {
            $balance = $opening_balance->opening_balance;
        } else {
            $balance = 0;
        }

        if ($diff > 0) {
            $account = Accounts::join('journal_entry_details as jed', 'coa.account_id', '=', 'jed.account_id')
                ->join('journal_entry as je', 'jed.journal_id', '=', 'je.journal_id')
                ->join('account_type as acctype', 'acctype.account_type_id', '=', 'coa.account_type_id')
                ->join('account_category as acccat', 'acccat.account_category_id', '=', 'acctype.account_category_id')
                ->select(
                    'coa.account_id',
                    'coa.account_number',
                    'coa.account_name',
                    'acccat.to_increase',
                    DB::raw('COALESCE(SUM(jed.journal_details_debit)) AS total_debit'),
                    DB::raw('COALESCE(SUM(jed.journal_details_credit)) AS total_credit')
                )
                ->from('chart_of_accounts as coa')
                ->whereIn('coa.type', ["L", "R"])
                ->where(['coa.account_id' => $account_id, 'je.status' => 'posted', 'jed.subsidiary_id' => $subsidiary_id])
                ->whereBetween("je.journal_date", [$startDate->toDateString(), $endDate->toDateString()])
                ->groupBy('coa.account_id', 'coa.account_number', 'coa.account_name')
                ->first();
            if ($account) {
                if ($account->to_increase == "debit") {
                    return $balance + $account->total_debit - $account->total_credit;
                } else {
                    return $balance - $account->total_debit + $account->total_credit;
                }
            }
        }

        return $balance;
    }

    public function getAccountBalance($from, $to, $account_id)
    {

        $cycle = Accounting::getFiscalYear(1);
        $startDate = Carbon::parse($cycle->start_date);
        $fromDate = Carbon::parse($from);
        $toDate = Carbon::parse($to);
        $diff = $startDate->diffInDays($fromDate);
        $endDate = Carbon::parse($fromDate->toDateString())->subDay(1);

        $balance = $this->getOpeningBalance($account_id);

        if ($diff > 0) {

            $account = Accounts::join('journal_entry_details as jed', 'coa.account_id', '=', 'jed.account_id')
                ->join('journal_entry as je', 'jed.journal_id', '=', 'je.journal_id')
                ->join('account_type as acctype', 'acctype.account_type_id', '=', 'coa.account_type_id')
                ->join('account_category as acccat', 'acccat.account_category_id', '=', 'acctype.account_category_id')
                ->select(
                    'coa.account_id',
                    'coa.account_number',
                    'coa.account_name',
                    'acccat.to_increase',
                    DB::raw('COALESCE(SUM(jed.journal_details_debit)) AS total_debit'),
                    DB::raw('COALESCE(SUM(jed.journal_details_credit)) AS total_credit')
                )
                ->from('chart_of_accounts as coa')
                ->whereIn('coa.type', ["L", "R"])
                ->where(['coa.account_id' => $account_id, 'je.status' => 'posted'])
                ->whereBetween("je.journal_date", [$startDate->toDateString(), $endDate->toDateString()])
                ->groupBy('coa.account_id', 'coa.account_number', 'coa.account_name')
                ->first();


            if ($account) {
                if ($account->to_increase == "debit") {
                    return $balance + $account->total_debit - $account->total_credit;
                } else {
                    return $balance - $account->total_debit + $account->total_credit;
                }
            }
        }

        return $balance;
    }

    public function getOpeningBalance($account_id)
    {

        $obj = OpeningBalance::where(['account_id' => $account_id])->first('opening_balance');

        if ($obj && isset($obj->opening_balance)) {
            return $obj->opening_balance;
        }

        return 0;
    }

    public function ledger($range = [], $account_id = '', $subsidiary_id = '')
    {

        $account = Accounts::join('journal_entry_details as jed', 'coa.account_id', '=', 'jed.account_id')
            ->join('journal_entry as je', 'jed.journal_id', '=', 'je.journal_id')
            ->join('subsidiary as sub', 'jed.subsidiary_id', '=', 'sub.sub_id')
            ->join('account_type as at', 'at.account_type_id', '=', 'coa.account_type_id')
            ->join('account_category as ac', 'ac.account_category_id', '=', 'at.account_category_id')
            ->join('branch as br', 'br.branch_id', '=', 'je.branch_id')
            ->select(
                'ac.account_category',
                'ac.to_increase',
                'at.account_type',
                'coa.account_id',
                'coa.account_number',
                'coa.account_name',
                'je.journal_date',
                'je.journal_id',
                'je.journal_no',
                'je.source',
                'je.cheque_no',
                'je.cheque_date',
                'je.payee',
                'je.remarks',
                'jed.journal_details_debit',
                'jed.journal_details_credit',
                'sub.sub_name',
                'ac.account_category',
                'ac.to_increase',
                'br.branch_name'
            )
            ->from('chart_of_accounts as coa')
            ->where(['je.status' => 'posted', 'coa.status' => 'active'])
            ->whereBetween("je.journal_date", $range);


        if ($account_id) {
            $account->where(['coa.account_id' => $account_id]);
        }
        if ($subsidiary_id) {
            $account->where(['jed.subsidiary_id' => $subsidiary_id]);
        }

        $data = $account->orderBy('je.journal_date', 'ASC')
            ->orderBy('jed.journal_id', 'ASC')
            ->get();

        $ledger = [];

        $current_balance = 0;
        $total_debit = 0;
        $total_credit = 0;

        foreach ($data as $key => $value) {

            if (!isset($ledger[$value->account_id])) {

                $balance = $this->getAccountBalance($range[0], $range[1], $value->account_id);
                $current_balance = $balance;
                $total_debit = 0;
                $total_credit = 0;

                $ledger[$value->account_id] = [
                    'account_category' => $value->account_category,
                    'account_type' => $value->account_type,
                    'account_number' => $value->account_number,
                    'account_name' => $value->account_name,
                    'branch_name' => $value->branch_name,
                    'balance' => number_format($balance, 2),
                    'current_balance' => 0,
                    'total_debit' => 0,
                    'total_credit' => 0,
                    'to_increase' => $value->to_increase,
                    'entries' => []
                ];
            }

            if (isset($value->to_increase) && strtolower($value->to_increase) == 'debit') {
                $current_balance += ($value->journal_details_debit - $value->journal_details_credit);
            } else {
                $current_balance += ($value->journal_details_credit - $value->journal_details_debit);
            }

            $total_debit += $value->journal_details_debit;
            $total_credit += $value->journal_details_credit;

            $ledger[$value->account_id]['current_balance'] = number_format($current_balance, 2);
            $ledger[$value->account_id]['total_debit'] = number_format($total_debit, 2);
            $ledger[$value->account_id]['total_credit'] = number_format($total_credit, 2);

            $ledger[$value->account_id]['entries'][] = [
                'journal_id' => $value->journal_id,
                'branch_name' => $value->branch_name,
                'sub_name' => $value->sub_name,
                'journal_date' => Carbon::parse($value->journal_date)->format('m/d/y'),
                'journal_no' => $value->journal_no,
                'source' => $value->source,
                'cheque_no' => $value->cheque_no,
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

    public function balanceSheet($range = [])
    {
        $accounts = Accounts::join('account_type as at', 'at.account_type_id', '=', 'coa.account_type_id')
            ->join('account_category as ac', 'ac.account_category_id', '=', 'at.account_category_id')
            ->select(
                'ac.account_category',
                'ac.account_category_id',
                'ac.to_increase',
                'at.account_type',
                'at.account_type_id',
                'coa.account_id',
                'coa.account_number',
                'coa.account_name',
            )
            ->from('chart_of_accounts as coa')
            ->where(['coa.status' => 'active'])
            ->whereIn('coa.type', ['L', 'R', 'X'])
            ->whereIn('at.account_category_id', [1, 2, 3])
            ->orderBy('coa.account_number', 'ASC')
            ->groupBy('coa.account_id')
            ->get();

        $sheet = [
            'accounts' => [],
            'total_asset' => 0
        ];

        foreach ($accounts as $account) {

            $data = journalEntry::leftJoin('journal_entry_details as jed', 'je.journal_id', '=', 'jed.journal_id')
                ->select(
                    DB::raw('SUM(jed.journal_details_debit) as debit'),
                    DB::raw('SUM(jed.journal_details_credit) as credit'),
                    DB::raw('(SUM(jed.journal_details_debit) - SUM(jed.journal_details_credit)) as total'),
                )
                ->from('journal_entry as je')
                ->whereBetween("je.journal_date", $range)
                ->where(['jed.account_id' => $account->account_id, 'je.status' => 'posted'])
                ->groupBy('jed.account_id')
                ->groupBy('jed.journal_details_account_no')
                ->limit(1)
                ->first();

            if ($data) {
                $account->debit = $data['debit'];
                $account->credit = $data['credit'];
                $account->total = $data['total'];
            } else {

                // account id of Current Earnings
                if ($account->account_id == 84) {
                    $account->debit = 0;
                    $account->credit = 0;
                    $account->total = $this->currentEarnings($range);
                } else {
                    $account->debit = 0;
                    $account->credit = 0;
                    $account->total = 0;
                }
            }

            // ------------------------------------------------------------------------

            if (!isset($sheet['accounts'][$account->account_category])) {
                $sheet['accounts'][$account->account_category] = [
                    'total' => 0,
                    'types' => []
                ];
            }

            if (!isset($sheet['accounts'][$account->account_category]['types'][$account->account_type_id])) {
                $sheet['accounts'][$account->account_category]['types'][$account->account_type_id] = [
                    'total' => 0,
                    'name' => $account->account_type,
                    'accounts' => []

                ];
            } else {
            }

            $opening_balance =  $this->getAccountBalance($range[0], $range[1], $account->account_id);

            if (isset($account->to_increase) && strtolower($account->to_increase) == 'debit') {
                $subtotal = ($account->total + $opening_balance);
            } else {
                $subtotal = abs($account->total - $opening_balance);
                // if( $account->total >= 0 ) {
                //    $subtotal = abs($account->total + $opening_balance);
                // }else{
                //     $subtotal = abs($account->total + ($opening_balance) * -1);
                // }


            }

            $sheet['accounts'][$account->account_category]['types'][$account->account_type_id]['accounts'][$account->account_id] = [
                'account_number' => $account->account_number,
                'account_name' => $account->account_name,
                'debit' =>  $account->debit,
                'credit' => $account->credit,
                'opening_balance' => $opening_balance,
                'total' => $subtotal,
                'computed' => $subtotal
            ];

            $sheet['accounts'][$account->account_category]['types'][$account->account_type_id]['total'] += $sheet['accounts'][$account->account_category]['types'][$account->account_type_id]['accounts'][$account->account_id]['computed'];

            $sheet['accounts'][$account->account_category]['total'] += $sheet['accounts'][$account->account_category]['types'][$account->account_type_id]['accounts'][$account->account_id]['computed'];
        }

        $sheet['total_asset'] = [
            'title' => 'TOTAL LIABILITIES AND EQUITY',
            'value' => ($sheet['accounts']['liabilities']['total'] + $sheet['accounts']['equity']['total'])
        ];

        return $sheet;
    }

    public function currentEarnings($range)
    {

        // $book_id = 9;
        $total = 0;
        // $accounts = [ 87, 166];
        // $account_id = 84;
        $accs = Accounts::whereHas('accountType.accountCategory', function (Builder $query) {
            $query->whereIn('account_category_id', [4, 5]);
        })
            ->get()->pluck("account_id");
        $data = journalEntry::join('journal_entry_details as jed', 'je.journal_id', '=', 'jed.journal_id')
            ->select(
                'je.journal_id',
                'je.journal_date',
                'je.book_id',
                'jed.journal_details_title as title',
                'jed.journal_details_debit as debit',
                'jed.journal_details_credit as credit',
                DB::raw('ROUND((jed.journal_details_credit / 1.12 * 0.12), 2) as vat'),
            )
            ->from('journal_entry as je')
            // ->whereBetween("je.journal_date", $range)
            ->whereBetween("je.journal_date", $range)
            // ->whereDate("je.journal_date", "=", $range[1])
            ->where(['je.status' => 'posted'])
            // ->where(['je.book_id' => $book_id])
            ->whereIn('jed.account_id', $accs)
            ->get();

        // $balance = $this->getOpeningBalance($account_id);
        foreach ($data as $d) {
            // $d->net = $d->credit - $d->vat;
            $total -= $d->credit;
            $total += $d->debit;
        }

        // return ['data' => $data->toArray(), $range, 'entries' => count($data->toArray()) , 'current_earnings' => round($total, 2)];
        return round($total, 2);
    }

    public function incomeStatement($range)
    {

        $accounts = Accounts::join('account_type as at', 'at.account_type_id', '=', 'coa.account_type_id')
            ->join('account_category as ac', 'ac.account_category_id', '=', 'at.account_category_id')
            ->select(
                'ac.account_category',
                'ac.account_category_id',
                'ac.to_increase',
                'at.account_type',
                'at.account_type_id',
                'coa.account_id',
                'coa.account_number',
                'coa.account_name',
            )
            ->from('chart_of_accounts as coa')
            ->where(['coa.status' => 'active'])
            ->whereIn('coa.type', ['L', 'R', 'X'])
            ->whereIn('ac.account_category', ['revenue', 'expense'])
            ->orderBy('coa.account_number', 'ASC')
            ->groupBy('coa.account_id')
            ->get();

        $sheet = [
            'accounts' => [],
            'profit' => [],
            'income_tax' => [],
            'net_income' => []
        ];

        foreach ($accounts as $account) {

            $data = journalEntry::leftJoin('journal_entry_details as jed', 'je.journal_id', '=', 'jed.journal_id')
                ->select(
                    DB::raw('SUM(jed.journal_details_debit) as debit'),
                    DB::raw('SUM(jed.journal_details_credit) as credit'),
                    DB::raw('(SUM(jed.journal_details_debit) - SUM(jed.journal_details_credit)) as total'),
                )
                ->from('journal_entry as je')
                ->whereBetween("je.journal_date", $range)
                ->where(['jed.account_id' => $account->account_id, 'je.status' => 'posted'])
                ->groupBy('jed.account_id')
                ->groupBy('jed.journal_details_account_no')
                ->limit(1)
                ->first();

            if ($data) {
                $account->debit = $data['debit'];
                $account->credit = $data['credit'];
                $account->total = $data['total'];
            } else {

                // // account id of Current Earnings
                // if( $account->account_id == 84 ) {
                //     $account->debit = 0;
                //     $account->credit = 0;
                //     $account->total = $this->currentEarnings($range);
                // }else{
                $account->debit = 0;
                $account->credit = 0;
                $account->total = 0;
                // }
            }

            // ------------------------------------------------------------------------

            if (!isset($sheet['accounts'][$account->account_category])) {
                $sheet['accounts'][$account->account_category] = [
                    'total' => 0,
                    'types' => []
                ];
            }

            if (!isset($sheet['accounts'][$account->account_category]['types'][$account->account_type_id])) {
                $sheet['accounts'][$account->account_category]['types'][$account->account_type_id] = [
                    'total' => 0,
                    'name' => $account->account_type,
                    'accounts' => []

                ];
            } else {
            }

            // $opening_balance =  $this->getAccountBalance($range[0], $range[1], $account->account_id);
            if (strtolower($account->account_category) == 'expense') {
                $subtotal = $account->total;
            } else {
                $subtotal = abs($account->total);
            }
            // if( isset($account->to_increase) && strtolower($account->to_increase) == 'debit' ) {
            //     $subtotal = ($account->total + $opening_balance);
            // }else{
            //       $subtotal = abs($account->total - $opening_balance);
            // }

            $sheet['accounts'][$account->account_category]['types'][$account->account_type_id]['accounts'][$account->account_id] = [
                'account_number' => $account->account_number,
                'account_name' => $account->account_name,
                'debit' =>  $account->debit,
                'credit' => $account->credit,
                // 'opening_balance' => $opening_balance,
                'total' => $subtotal,
                'computed' => $subtotal
            ];

            $sheet['accounts'][$account->account_category]['types'][$account->account_type_id]['total'] += $sheet['accounts'][$account->account_category]['types'][$account->account_type_id]['accounts'][$account->account_id]['computed'];

            $sheet['accounts'][$account->account_category]['total'] += $sheet['accounts'][$account->account_category]['types'][$account->account_type_id]['accounts'][$account->account_id]['computed'];
        }


        $sheet['profit'] = [
            'title' => 'Profit / (Loss) before tax',
            'value' => ($sheet['accounts']['revenue']['total'] - $sheet['accounts']['expense']['total'])
        ];

        $sheet['income_tax'] = [
            'title' => 'Less Provision for Income tax (0%)',
            'value' => 0
        ];

        $sheet['net_income'] = [
            'title' => 'Net Income / (Loss)',
            'value' => ($sheet['profit']['value'] - $sheet['income_tax']['value'])
        ];

        return $sheet;
    }

    public function bankReconciliation() {}
}
