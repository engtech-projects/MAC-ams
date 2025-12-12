<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Transactions;
use App\Models\PaymentMethod;
use App\Models\Accounts;
use App\Models\TransactionType;
use App\Models\TransactionStatus;

class PaymentController extends MainController
{
    //

	public function create($id) {

		$transaction = new Transactions();
		// $transactionData = $transaction->getTransactionById($id);
		$transactionType = TransactionType::where('transaction_type', 'payment')->first();

		$data = [
 			'customers' => Customer::all(),
 			'transaction' => $transaction->getTransactionById($id),
 			'assets' => Accounts::assets(),
 			'paymentMethod' => PaymentMethod::all(),
 			'transactionType' => $transactionType,
    		'transactionStatus' => TransactionStatus::where(['default' => 1, 'transaction_type_id' => $transactionType->transaction_type_id])->first()
 		];

 		return view('payment.create'.$data['transaction']->transaction_type.'payment', $data);
	}

	public function invoicePayment($id) {

	}

	public function customerPayment($id) {

		$transactions = new Transactions();
		$invoices = $transactions->invoice(['customer' => $id, 'status' => 'open', 'dateRange' => NULL]);

		$data = [
 			'customer' => Customer::find($id),
 			'assets' => Accounts::assets(),
 			'paymentMethod' => PaymentMethod::all(),
 			'invoices' => $invoices
 		];

		return view('payment.invoice', $data);
	}

	public function billPayment() {}
	public function supplierPayment() {}

	public function store(Request $request) {

		$transactions = new Transactions();
    	return $transactions->store($transactions, $request);
		// var_export($request->input());
	}

}
