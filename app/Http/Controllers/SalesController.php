<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Hash;
use Session;
use App\Models\User;
use App\Models\Customer;
use App\Models\Terms;
use App\Models\ProductsServices;
use Illuminate\Support\Facades\Auth;
use App\Models\Transactions;
use App\Models\TransactionType;
use App\Models\TransactionStatus;
use App\Models\Invoice;
use Carbon\Carbon;
use App\Http\Resources\InvoiceCollection;

class SalesController extends MainController
{

 	public function index() {

 		$transactionType = TransactionType::where('transaction_type', 'invoice')->first();

 		$data = [
            'title' => 'Sales Transactions',
            'customers' => Customer::all(),
            'transactionStatus' => TransactionStatus::where(['transaction_type_id' => $transactionType->transaction_type_id])->get()
        ];

    	return view('sales.sales', $data);

 	}

 	public function create($type, Request $request) {
 		$transactionType = TransactionType::where('transaction_type', $type)->first();
		$invoice = null;
		if(isset($request->id) && $type == 'invoice'){
			$invoice = (new Invoice())->with(['customer', 'transaction', 'transaction.items', 'transaction.details', 'transaction.items.item','transaction.type'])->where('transaction_id', $request->id)->first();
		}

 		$data = [
 			'customers' => Customer::all(),
 			'terms' => Terms::all(),
 			'productsServices' => ProductsServices::all(),
 			'transactionType' => $transactionType,
    		'transactionStatus' => TransactionStatus::where(['default' => 1, 'transaction_type_id' => $transactionType->transaction_type_id])->first(),
			'invoice' => $invoice
 		];
 		return view('sales.create'.$type, $data);
 	}

 	public function store(Request $request) {

 		$transactions = new Transactions();
 		return $transactions->store($transactions, $request);
 	}

 	public function show($id) {}
 	public function populate(Request $request) {

 		$transactions = new Transactions();

 		if( $request->type == 'sales' ){
 			return $transactions->sales(
                [
                    'status' => $request->status,
                    'customer' =>  $request->customer,
                    'dateRange' => array(
                        'from' => $request->from,
                        'to' => $request->to
                    )
                ]);
 		}

 		if( $request->type == 'invoice' ){
 			return new InvoiceCollection($transactions->invoice(
                [
                    'status' => $request->status,
                    'customer' =>  $request->customer,
                    'dateRange' => array(
                        'from' => $request->from,
                        'to' => $request->to
                    )
                ], true));
 		}
 	}

 	// invoice
 	public function invoice() {

 		$transactionType = TransactionType::where('transaction_type', 'invoice')->first();

 		$data = [
            'title' => 'Invoices',
            'transactionStatus' => TransactionStatus::where(['transaction_type_id' => $transactionType->transaction_type_id])->get()
        ];

    	return view('sales.invoice', $data);
 	}
}
