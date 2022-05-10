<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Hash;
use Session;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\AccountType;
use App\Models\Accounts;

class AccountsController extends MainController
{
    public function index() {
        $data = [
            'title' => 'Chart of Accounts',
            'accounts' => Accounts::fetch(),
        ];

    	return view('chartofaccounts.accounts', $data);
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
