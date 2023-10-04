<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Accounts;
use App\Models\journalEntryDetails;
use App\Models\AccountType;

class Accounts extends Model
{
    use HasFactory;

    protected $table = 'chart_of_accounts';
    protected $primaryKey = 'account_id';
    public $timestamps = true;


    protected $fillable = [
    	'account_number', 'account_name', 'account_description', 'status', 'account_type_id', 'parent_account','bank_reconcillation'
    ];


	public function accountType(){
		return $this->hasMany(AccountType::class, 'account_type_id');
    }



    public function store(Array $data) {
        $account = new Accounts();
        $account->account_number = $data['account_number'];
        $account->account_name = $data['account_name'];
        $account->account_description = $data['account_description'];
        $account->statement = isset($data['statement']) ? $data['statement'] : NULL;
        $account->status = 'active';
        $account->account_type_id = $data['account_type_id'];
        $account->bank_reconcillation = $data['bank_reconcillation'];
        $account->parent_account = isset($data['parent_account']) ? $data['parent_account'] : NULL;

        if( $account->save() ){
            return response()->json(array('success' => true, 'message' => 'New account created!'), 200);
        }
        return response()->json(array('success' => false, 'message' => 'Something went wrong!'), 200);
    }


    public static function fetchAccountByAccountType($isJson = false) {
        $jsonData = [];
        $data = DB::table('chart_of_accounts')
                    ->join('account_type', 'account_type.account_type_id', '=', 'chart_of_accounts.account_type_id')
                    ->join('account_category', 'account_category.account_category_id', '=', 'account_type.account_category_id')
                    ->select('chart_of_accounts.*', 'account_type.*', 'account_category.account_category.')
                    ->where('status', 'active')
                    ->orderBy('account_category.account_category_id', 'asc')
                    ->orderBy('account_type.account_type_id', 'asc')
                    ->get();

		if(count($data) > 0)
		{
			if ($isJson) {
				foreach ($data->toArray() as $key => $value) {
					$row = [];
					foreach ($value as $k => $v) {
						if($k == 'account_type'){
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


    public static function fetch($isJson = false) {
		$jsonData = [];
        $data = DB::table('chart_of_accounts')
                    ->join('account_type', 'account_type.account_type_id', '=', 'chart_of_accounts.account_type_id')
                    ->join('account_category', 'account_category.account_category_id', '=', 'account_type.account_category_id')
                    ->select('chart_of_accounts.*', 'account_type.account_type', 'account_type.*', 'account_category.account_category')
                    ->where(['status' => 'active', 'type' => 'L'])
                    ->orderBy('account_category.account_category_id', 'asc')
                    ->orderBy('account_type.account_type_id', 'asc')
                    ->get();

		if(count($data) > 0)
		{
			if ($isJson) {
				foreach ($data->toArray() as $key => $value) {
					$row = [];
					foreach ($value as $k => $v) {
						if($k == 'account_type'){
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

    public static function show($account_id) {
        $data = DB::table('chart_of_accounts')
                    ->join('account_type', 'account_type.account_type_id', '=', 'chart_of_accounts.account_type_id')
                    ->join('account_category', 'account_category.account_category_id', '=', 'account_type.account_category_id')
                    ->select('chart_of_accounts.*', 'account_type.account_type', 'account_type.account_type_id', 'account_category.account_category')
                    ->where('status', 'active')
                    ->where('chart_of_accounts.account_id', $account_id)
                    ->first();
        return $data;
    }

    public function edit(Request $request, Accounts $account){

        if( $account->update($request->all()) ){
            return response()->json(array('success' => true, 'message' => 'Account has been updated!'), 200);
        }
        return response()->json(array('success' => false, 'message' => 'Something went wrong!'), 200);
    }

    # function that checks transaction that is linked to a particular account.
    # fix associated transactions
    public function checkAccountLink() {}

    public function setStatus(Request $request) {

        $account = Accounts::find($request->id);
        $account->status = $request->status;

        if ($account->save() ) {
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

    public static function assets(){
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

    public static function liabilities(){
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

    public static function equity(){
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

    public static function income(){
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

    public static function expense() {
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
    public static function getTrialBalance($from='', $to='', $account_id='')
    {
        $query = DB::table("chart_of_accounts")
              ->select(DB::raw("chart_of_accounts.account_name,
                    chart_of_accounts.account_number    ,
                    SUM(journal_entry_details.journal_details_debit) as total_debit ,
                    SUM(journal_entry_details.journal_details_credit) as total_credit"))
                ->join("journal_entry_details", function($join){
                    $join->on("chart_of_accounts.account_id", "=", "journal_entry_details.account_id");
                })
                ->join("journal_entry", function($join){
                    $join->on("journal_entry_details.journal_id", "=", "journal_entry.journal_id");
                });

               $query->groupBy("chart_of_accounts.account_id");
        return $query->get();
    }
    //gerneralLedger (All Account)
	public static function generalLedger_fetchAccounts($from='', $to='', $account_id='')
	{
		$journalEntries = JournalEntry::join('journal_book', 'journal_entry.book_id', '=', 'journal_book.book_id')
        ->join('journal_entry_details', 'journal_entry_details.journal_id', '=', 'journal_entry.journal_id')
        ->join('chart_of_accounts', 'journal_entry_details.account_id', '=', 'chart_of_accounts.account_id')
        ->join('subsidiary', 'journal_entry_details.subsidiary_id', '=', 'subsidiary.sub_id')
        ->leftJoin('opening_balance', 'chart_of_accounts.account_id','=','opening_balance.account_id')
        ->select(
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
            'journal_entry_details.balance'
        );

        if($from != '' && $to != '')
        {
            $journalEntries->whereBetween("journal_entry.journal_date", [$from, $to]);
        }
		if($account_id != '')
		{
			$journalEntries->where('chart_of_accounts.account_id', $account_id);
		}

		return $journalEntries->orderBy('chart_of_accounts.account_number', 'ASC')->orderBy('journal_entry.journal_date', 'ASC')->paginate(50);
}
}