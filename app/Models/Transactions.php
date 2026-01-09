<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Models\Transactions;
use App\Models\TransactionType;
use App\Models\TransactionDetails;
use App\Models\Expense;
use App\Models\Bill;
use App\Models\Supplier;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
// use DB;

class Transactions extends Model
{
    use HasFactory;

    protected $table = 'transactions';
    protected $primaryKey = 'transaction_id';
    public $timestamps = true;

    protected $fillable = [
    	'transaction_type_id', 'note', 'attachments', 'status', 'transaction_date', 'created_by', 'updated_by'
    ];

    /*
        SORT DATES
    */
    public function cmp($a, $b){
        $ad = strtotime($a['transaction_date']);
        $bd = strtotime($b['transaction_date']);
        return ($bd-$ad);
    }

	public function xpense(){
		return $this->hasOne(Expense::class, 'transaction_id');
	}

	public function details(){
		return $this->hasMany(TransactionDetails::class, 'transaction_id');
	}

	public function type(){
		return $this->belongsTo(TransactionType::class, 'transaction_type_id');
	}

	public function items(){
		return $this->hasMany(ItemDetail::class, 'transaction_id');
	}

    public function store(Transactions $transaction, Request $request) {

        $transaction->transaction_type_id = $request->transaction_type_id;
        $transaction->transaction_date = Carbon::now()->format('Y-m-d');
        $transaction->note = $request->note;
        $transaction->status = $request->status;
        $transaction->created_by = Auth::user()->id;
        $transaction->save();

        if( $transaction->transaction_id ){

            // add expense/bill details
            $data = array(); // transactionDetails data
            $isSuccessful = false;
            switch ($request->transaction_type) {

                case 'expense':

                    $expense = new Expense();
                    $isSuccessful = $expense->store($request, $transaction->transaction_id);
                    break;

                case 'bill':

                    $bill = new Bill();
                    $isSuccessful = $bill->store($request, $transaction->transaction_id);
                    break;

                case 'invoice':

                    $invoice = new Invoice();
                    $isSuccessful = $invoice->store($request, $transaction->transaction_id);
                    break;

                case 'payment':
                    $payment = new Payment();
                    $isSuccessful = $payment->store($request, $transaction->transaction_id);
                    break;
            }

            if( $isSuccessful ){
                return response()->json(array('success' => true, 'message' => 'Transaction has been saved!'), 200);
            }
        }
        return response()->json(array('success' => false, 'message' => 'Something went wrong!'), 200);
    }

    public function void($id, $status) {

        $transaction = Transactions::find($id);
        $transaction->status = $status;

        if ($transaction->save() ) {

            return response()->json(array('success' => true, 'message' => 'Transaction has been voided!'), 200);

        }

        return response()->json(array('success' => false, 'message' => 'Something went wrong!'), 200);
    }

    public function remove() {

        $transaction = Transactions::find($id);
        $transaction->status = $status;

        if ($transaction->save() ) {

            return response()->json(array('success' => true, 'message' => 'Transaction has been deleted!'), 200);

        }

        return response()->json(array('success' => false, 'message' => 'Something went wrong!'), 200);
    }

    public function sales( $filters = NULL ) {

        $invoice = $this->invoice($filters);
        $payment = $this->payment($filters);

        $data = array_merge($invoice->toArray(), $payment->toArray());
        usort($data, array($this, 'cmp'));

        $sales = [];
        foreach ($data as $key => $value) {

            $sales[] = [
                'transaction_id' => $value['transaction_id'],
                'date' => $value['transaction_date'],
                'type' => $value['transaction_type'],
                'no' => $value['no'],
                'customer' => $value['displayname'],
                'due_date' => ($value['transaction_type'] == 'invoice') ? $value['due_date'] : '',
                'balance' => Payment::getBalanceFromInvoice($value['invoice_id']),
                'total' => $value['total_amount'],
                'status' => $value['status']
            ];

        }

        $jsonData['data'] = [];
        // prepare data for datatable
        foreach ($sales as $key => $value) {
            $row = [];
            foreach ($value as $k => $v) {
                $row[$k] = utf8_encode($v);
            }
            $jsonData['data'][] = $row;
        }
        return json_encode($jsonData);
    }

    public function invoice( $filters = NULL, $exclusive = false ) {

        $invoice = Transactions::leftJoin('transaction_type', 'transactions.transaction_type_id', '=', 'transaction_type.transaction_type_id')
            ->leftJoin('invoice', 'transactions.transaction_id', '=', 'invoice.transaction_id')
            ->leftJoin('customer', 'invoice.customer_id', '=', 'customer.customer_id')
            ->orderBy('transactions.transaction_date', 'asc')
            ->select(
                'transactions.transaction_id',
                'transactions.status',
                'transactions.transaction_date',
                'transaction_type.transaction_type',
                'invoice.invoice_id',
                'invoice.invoice_no as no',
                'invoice.due_date',
                'invoice.total_amount',
                'customer.displayname'
                )

            ->where('transaction_type.transaction_type', 'invoice');

        if (is_array($filters) && count($filters) > 0 ){

            if( $filters['customer'] != 'all'  ) {
                $invoice = $invoice->where('invoice.customer_id', $filters['customer']);
            }

            if( $filters['status'] != 'all'  ) {
                $invoice = $invoice->where('transactions.status', $filters['status']);
            }

            if( $filters['dateRange'] ){
                $invoice = $invoice->whereBetween('invoice.invoice_date', [$filters['dateRange']['from'], $filters['dateRange']['to']]);
            }
        }

        // for datatable
        if( $exclusive ){
            $data = $invoice->get();
            foreach ($data as $key => $value) {
                $value->date = $value->transaction_date;
                $value->customer = $value->displayname;
                $value->amount = $value->total_amount;
                $value->balance = Payment::getBalanceFromInvoice($value->invoice_id);
            }

            return $data;

        }

        $data = $invoice->get();
        foreach ($data as $key => $value) {
            $value->balance = Payment::getBalanceFromInvoice($value->invoice_id);
        }

        return $data;
    }

    public function payment( $filters = NULL ) {

        $payment = Transactions::leftJoin('transaction_type', 'transactions.transaction_type_id', '=', 'transaction_type.transaction_type_id')
                ->leftJoin('payment', 'transactions.transaction_id', '=', 'payment.transaction_id')
                ->leftJoin('invoice', 'payment.reference_id', '=', 'invoice.invoice_id')
                ->leftJoin('customer', 'invoice.customer_id', '=', 'customer.customer_id')
                ->orderBy('transactions.transaction_date', 'asc')
                ->select(
                    'transactions.transaction_id',
                    'transactions.status',
                    'transactions.transaction_date',
                    'transaction_type.transaction_type',
                    'payment.payment_id as no',
                    'payment.amount as total_amount',
                    'payment.transaction',
                    'payment.reference_id',
                    'payment.reference_id as invoice_id',
                    'customer.displayname'
                    )

                ->where('transaction_type.transaction_type', 'payment')
                ->where('payment.transaction', 'invoice');

        if (is_array($filters) && count($filters) > 0 ){

            if( $filters['customer'] != 'all'  ) {
                $payment = $payment->where('invoice.customer_id', $filters['customer']);
            }

            if( $filters['status'] != 'all'  ) {
                $payment = $payment->where('transactions.status', $filters['status']);
            }

            if( $filters['dateRange'] ){
                $payment = $payment->whereBetween('payment.payment_date', [$filters['dateRange']['from'], $filters['dateRange']['to']]);
            }
        }

        return $payment->get();
    }

    public function bill( $filters = NULL ) {

        $bill = Transactions::join('bill', 'transactions.transaction_id', '=', 'bill.transaction_id')
                    ->join('transaction_type', 'transactions.transaction_type_id', '=', 'transaction_type.transaction_type_id')
                    ->orderBy('transactions.transaction_date', 'asc')
                    ->select(
                        'transactions.*',
                        'transaction_type.transaction_type',
                        'bill.*'
                    );

        $bill->whereIn('transactions.status', ['paid', 'void', 'open', 'overdue']);

        if( is_array( $filters ) && count($filters) ) {

            if( isset($filters['transaction_id']) && $filters['transaction_id'] > 0 ) {
                $bill->where('transactions.transaction_id', $filters['transaction_id']);
            }

            if( isset($filters['status']) && $filters['status'] != 'all') {
                $bill->where('transactions.status', $filters['status']);
            }

            if( $filters['dateRange'] ){
                $bill = $bill->whereBetween('bill.bill_date', [$filters['dateRange']['from'], $filters['dateRange']['to']]);
            }
        }

        $data = $bill->get();

        foreach ($data as $key => $value) {

            $value->details = TransactionDetails::getDetails($value->transaction_id)->toArray();
            $value->payment_date = date('Y-m-d', strtotime($value->payment_date));
            // update balance
            $value->balance = '';
            $value->no =  $value->bill_no;
            $value->due_date = Carbon::createFromFormat('Y-m-d', $value->due_date)->format('m/d/Y');
            $value->transaction_date = Carbon::createFromFormat('Y-m-d', $value->transaction_date)->format('m/d/Y');
            $value->transaction_type = ucfirst($value->transaction_type);
            // get payee
            if( $value->payee_type == 'supplier' ) {
                $value->name = Supplier::find($value->payee)->displayname;
            }
        }

        return $data;
    }

    public function expense( $filters = NULL ) {

        $expense = Transactions::join('expense', 'transactions.transaction_id', '=', 'expense.transaction_id')
                    ->join('transaction_type', 'transactions.transaction_type_id', '=', 'transaction_type.transaction_type_id')
                    ->orderBy('transactions.transaction_date', 'asc')
                    ->select(
                        'transactions.*',
                        'transaction_type.transaction_type',
                        'expense.*'
                    );
        $expense->whereIn('transactions.status', ['paid', 'void', 'open']);


        if( is_array( $filters ) && count($filters) ) {

            if( isset($filters['transaction_id']) && $filters['transaction_id'] > 0 ) {
                $expense->where('transactions.transaction_id', $filters['transaction_id']);
            }

            if( isset($filters['status']) && $filters['status'] != 'all') {
                $expense->where('transactions.status', $filters['status']);
            }

            // if( $filters['dateRange'] ){
            //     $expense = $expense->whereBetween('expense.payment_date', [$filters['dateRange']['from'], $filters['dateRange']['to']]);
            // }


        }

        $data = $expense->get();

        foreach ($data as $key => $value) {

            $value->details = TransactionDetails::getDetails($value->transaction_id)->toArray();
            $value->payment_date = date('Y-m-d', strtotime($value->payment_date));
            // update balance
            $value->balance = '';
            $value->no =  $value->reference_no;
            $value->due_date = '';
            $value->transaction_date = Carbon::createFromFormat('Y-m-d', $value->transaction_date)->format('m/d/Y');
            $value->transaction_type = ucfirst($value->transaction_type);
            // get payee
            if( $value->payee_type == 'supplier' ) {
                $value->name = Supplier::find($value->payee)->displayname;
            }
        }

        return $data;
    }

    public function expenses( $filters = NULL ) {

        $expense = $this->expense($filters);
        $bill    = $this->bill($filters);

        $data = array_merge($expense->toArray(), $bill->toArray());
        usort($data, array($this, 'cmp'));

        $expenses = [];
        foreach ($data as $key => $value) {

            $expenses[] = [
                'date' => $value['transaction_date'],
                'type' => $value['transaction_type'],
                'no' => $value['no'],
                'payee' => $value['name'],
                'due_date' => $value['due_date'],
                'balance' => $value['balance'],
                'total' => $value['total_amount'],
                'status' => $value['status'],

                'transaction_id' => $value['transaction_id'],
                // 'date' => $value['transaction_date'],
                // 'type' => $value['transaction_type'],
                // 'no' => $value['no'],
                // 'customer' => $value['displayname'],
                // 'due_date' => ($value['transaction_type'] == 'invoice') ? $value['due_date'] : '',
                // 'balance' => Payment::getBalanceFromInvoice($value['invoice_id']),
                // 'total' => $value['total_amount'],
                // 'status' => $value['status']
            ];

        }

        $jsonData['data'] = [];
        // prepare data for datatable
        foreach ($expenses as $key => $value) {
            $row = [];
            foreach ($value as $k => $v) {
                $row[$k] = utf8_encode($v);
            }
            $jsonData['data'][] = $row;
        }
        return json_encode($jsonData);

        // $expenses = Transactions::leftJoin('transaction_type', 'transactions.transaction_type_id', '=', 'transaction_type.transaction_type_id')

        //         ->leftJoin('bill', 'transactions.transaction_id', '=', 'bill.transaction_id')
        //         ->leftJoin('expense', 'transactions.transaction_id', '=', 'expense.transaction_id')
        //         ->orderBy('transactions.transaction_date', 'asc')
        //         ->select(
        //             'transactions.*',
        //             'transaction_type.transaction_type',
        //             'bill.*', 'bill.total_amount as bill_total', 'bill.payee as bill_payee', 'bill.payee_type as bill_payee_type',
        //             'expense.*', 'expense.total_amount as expense_total'
        //             )
        //         ->whereIn('transaction_type.transaction_type', ['bill', 'expense']);
        //         // ->get();

        // if( is_array($filters) && count($filters) > 0 ) {

        //     if( isset($filters['transaction_id']) && $filters['transaction_id'] > 0 ){
        //         $expenses->where('transactions.transaction_id', $filters['transaction_id']);
        //     }
        // }

        // $data = $expenses->get();

        // foreach ($data as $key => $value) {

        //     if( $value->transaction_type == 'bill' ){
        //         $value->no = $value->bill_no;
        //         $value->total = $value->bill_total;
        //         // get payee
        //         if( $value->bill_payee_type == 'supplier' ) {
        //             $value->name = Supplier::find($value->bill_payee)->displayname;
        //             $value->due_date = Carbon::createFromFormat('Y-m-d', $value->due_date)->format('m/d/Y');
        //         }
        //         // get from other payee type
        //     }

        //     if( $value->transaction_type == 'expense' ){
        //         $value->no =  $value->reference_no;
        //         $value->total = $value->expense_total;
        //         // get payee
        //         if( $value->payee_type == 'supplier' ) {
        //             $value->name = Supplier::find($value->payee)->displayname;
        //         }
        //         // get from other payee type
        //     }

        //     // to be updated.. .
        //     $value->balance = '';
        //     // $value->name = '';
        //     $value->transaction_date = Carbon::createFromFormat('Y-m-d', $value->transaction_date)->format('m/d/Y');
        //     $value->transaction_type = ucfirst($value->transaction_type);
        // }

        // return $data;
    }

    public function getTransactionById($transaction_id) {

        $transaction = Transactions::leftJoin('transaction_type', 'transactions.transaction_type_id', '=', 'transaction_type.transaction_type_id')
                    ->select(
                    'transactions.*',
                    'transaction_type.transaction_type'
                    )
                    ->where('transactions.transaction_id', $transaction_id)
                    ->first();

        switch ($transaction->transaction_type) {

            case 'invoice':
                $transaction->invoice = Invoice::where('transaction_id', $transaction->transaction_id)->first();
                $transaction->invoice->description = ucfirst($transaction->transaction_type);

                if( $transaction->invoice->invoice_no ){
                    $transaction->invoice->description .= ' #'.$transaction->invoice->invoice_no;
                }

                $transaction->invoice->due_date = Carbon::createFromFormat('Y-m-d', $transaction->invoice->due_date)->format('m/d/Y');
                $transaction->invoice->amount;
                $transaction->invoice->balance = Payment::getBalanceFromInvoice($transaction->invoice->invoice_id);
                break;

            default:
        }

        return $transaction;
    }

}
