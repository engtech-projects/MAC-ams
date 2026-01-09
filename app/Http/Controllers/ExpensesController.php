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
use App\Models\SupplierAddress;
use App\Models\PaymentMethod;
use App\Models\Transactions;
use App\Models\TransactionType;
use App\Models\TransactionStatus;
use App\Models\Terms;
use Carbon\Carbon;
use App\Http\Resources\ExpenseCollection;
use Illuminate\Support\Arr;

class ExpensesController extends MainController
{
    public function index() {

        $transactions = new Transactions();
        $transactionType = TransactionType::select('transaction_type_id')->whereIn('transaction_type', ['expense', 'bill'])->get()->toArray();
        $status = TransactionStatus::statuses(Arr::flatten($transactionType));

        $data = [
            'title' => 'Expense',
            'expenses' => $transactions->expenses(),
            'suppliers' => Supplier::with('address')->get(),
            'customers' => Customer::all(),
            'employees' => Employee::all(),
            'transactionStatus' => $status

        ];

    	return view('expenses.expenses', $data);

        // echo '<pre>';
        // var_export($status);
        // echo '</pre>';
    }

    public function create(Request $request, $type) {
    	$supplier = new Supplier();
    	$transactionType = TransactionType::where('transaction_type', $type)->first();

    	$data = [
    		'assets' => Accounts::assets(),
    		'expense' => Accounts::expense(),
    		'suppliers' => Supplier::with('address')->get(),
    		'transactionType' => $transactionType,
    		'transactionStatus' => TransactionStatus::where(['default' => 1, 'transaction_type_id' => $transactionType->transaction_type_id])->first(),
            'terms' => Terms::all(),
    		'paymentMethod' => PaymentMethod::all(),
			'copy' => isset($request->id)? Transactions::with('xpense', 'xpense.supplier', 'xpense.paymentMethod', 'details')->find($request->id) : null,
    	];
		// dd($data);
    	return view('expenses.create'.$type, $data);
    }

    public function store(Request $request) {

    	$transactions = new Transactions();
    	return $transactions->store($transactions, $request);
    }

    public function populate(Request $request) {

        // var_export($request->input());
        $transactions = new Transactions();
        return $transactions->expenses(
            [
                'status' => $request->status, 
                'payee' =>  $request->payee, 
                'payeeType' =>  $request->payeeType, 
                'dateRange' => array(
                                'from' => $request->from, 
                                'to' => $request->to
                            )  
            ]
        );
        // return new ExpenseCollection(
        //     $transactions->expense()
        // );
    }

    public function show($id) {

        $transactions = new Transactions();
        $supplier = new Supplier();
        $expenseItem = $transactions->expense(['transaction_id' => $id])->first();
        $transactionType = TransactionType::where('transaction_type', $expenseItem->transaction_type)->first();
       

        $data = [
            'assets' => Accounts::assets(),
            'expense' => Accounts::expense(),
            'suppliers' => Supplier::with('address')->get(),
            'transactionType' => $transactionType,
            'transactionStatus' => TransactionStatus::where(['default' => 1, 'transaction_type_id' => $transactionType->transaction_type_id])->first(),
            'terms' => Terms::all(),
            'paymentMethod' => PaymentMethod::all(),
            'expenseItem' => $expenseItem
        ];

        
        return view('expenses.expenseviewedit', $data);
        // echo '<pre>';
        // var_export($expenseItem->toArray());
        // echo '</pre>';

    }

    public function void(Request $request) {
        $transactions = new Transactions();
        return $transactions->void($request->id, $request->status);
    }

    public function remove() {

    }


}
