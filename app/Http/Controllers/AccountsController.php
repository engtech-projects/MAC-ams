<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Hash;
use Session;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\AccountType;
use App\Models\Accounts;
use App\Models\AccountCategory;

class AccountsController extends MainController
{
    public function index() {
		$accountData = Accounts::fetch();
        $data = [
            'title' => 'Chart of Accounts',
            'accounts' => Accounts::fetch(),
            'account_by_type' => $this->groupByAccountType($accountData),
			'organizedAccount'=> $this->groupByType($accountData),
			'account_category'=> AccountCategory::get(),
			'accountTypes' => AccountType::orderBy('account_category_id')->get(),
            'cashFlows'    => ['investing', 'financing', 'operating']
        ];
    	return view('chartofaccounts.accounts', $data);
    }

    public function groupByAccountType($data = [])
	{
		$currentType = '';
		$temp = [];
		$tempType = [];
        $type ='';
        $account_number = '';
        $account = null;

		if(count($data) > 0)
		{
			foreach($data as $key => $value)
			{
                //GET ACCOUNT TYPE
				if($type == '')
				{
					$type = $value->account_type;
                    $account_number = $value->account_no;
                    $account = $value;
				}else if($type != $value->account_type )
				{

					$type = $value->account_type;
                    $account_number = $value->account_no;
                    $account = $value;
                    $account = null;
					$tempType = [];
				}

                //GET ACCOUNT CATEGORY
                if($currentType == '')
                {
                    $currentType = $value->account_category;
                }else if($currentType != $value->account_category)
                {
                    $currentType = $value->account_category;
                    $tempType = [];

                }

                //CHART OF ACCOUTNS ORGANIZED DATA
				if($value->parent_account == '')
				{
					array_push($tempType,
						['account_id' => $value->account_id,
						'account_number' => $value->account_number,
						'account_name' => $value->account_name,
						'account_description' => $value->account_description,
						'parent_account' => $value->parent_account,
						'statement' => $value->statement,
						'status' => $value->status,
						'account_type_id' => $value->account_type_id,
                        'account_type' => $value->account_type,
						'created_at' => $value->created_at,
						'updated_at' => $value->updated_at,
						'account_type' => $value->account_type,
						'account_category' => $value->account_category,
						'bank_reconcillation' => $value->bank_reconcillation,
						'child' => Accounts::where("parent_account", $value->account_id)->with(['accountType.accountCategory'])->get()]
					);
				}
                $temp[$currentType][$account_number.' - '.$type] = $tempType;



			}


		}
		return $temp;
	}

	public function groupByType($data = [])
	{
		$currentType = '';
		$temp = [];
		$tempType = [];
		if(count($data) > 0)
		{
			foreach($data as $key => $value)
			{
				if($currentType == '')
				{
					$currentType = $value->account_category;
				}else if($currentType != $value->account_category)
				{
					$currentType = $value->account_category;
					$tempType = [];
				}

				if($value->parent_account == '')
				{
					array_push($tempType,
						['account_id' => $value->account_id,
						'account_number' => $value->account_number,
						'account_name' => $value->account_name,
						'account_description' => $value->account_description,
						'parent_account' => $value->parent_account,
						'statement' => $value->statement,
						'status' => $value->status,
						'account_type_id' => $value->account_type_id,
                        'account_type' => $value->account_type,
						'created_at' => $value->created_at,
						'updated_at' => $value->updated_at,
						'account_type' => $value->account_type,
						'account_category' => $value->account_category,
						'bank_reconcillation' => $value->bank_reconcillation,
						'child' => Accounts::where("parent_account", $value->account_id)->with(['accountType.accountCategory'])->get()]
					);
				}

				$temp[$currentType]['content'] = $tempType;

			}


		}
		return $temp;
	}

	public function saveClass(Request $request)
	{
		$class = $request->class_name;
		$cat = new AccountCategory;
		$cat->account_category = $class;

		if($cat->save())
		{
			return 'true';
		}
		return 'false';
	}

	public function saveType(Request $request)
	{
		$type = new AccountType;
		$type->account_no = $request->account_number;
		$type->account_type = $request->account_type_name;
		$type->has_opening_balance = '0';
		$type->account_category_id = $request->category_type_id;

		if($type->save())
		{
			return 'true';
		}
		return 'false';
	}


    public function populate() {
        return Accounts::fetch(true);
    }

    public function create(){
        $data = [
            'accountTypes' => AccountType::orderBy('account_category_id')->get(),
            'accounts'     => Accounts::fetch(),
            'cashFlows'    => ['investing', 'financing', 'operating']
        ];

        return view('chartofaccounts.createaccount', $data);
    }

    public function store(Request $request) {

    	$account = new Accounts();
    	return $account->store($request->input());
    }

	public function import(Request $request){
		foreach ($request->accounts as $key => $account) {
			$acc = new Accounts();
			$acc->store($account);
		}
		return 1;
	}

    public function show(Accounts $account) {

        $data = [
            'account'      => Accounts::show($account->account_id),
            'accountTypes' => AccountType::orderBy('account_category_id')->get(),
            'accounts'     => Accounts::fetch(),
            'cashFlows'    => ['investing', 'financing', 'operating']
        ];

        return view('chartofaccounts.editaccount', $data);
    }

    public function update(Request $request, Accounts $account) {
        return $account->edit($request, $account);
    }

    public function setStatus(Request $request) {
        $account = new Accounts();
        return $account->setStatus($request);
    }

}
