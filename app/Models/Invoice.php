<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Models\ItemDetail;

class Invoice extends Model
{
    use HasFactory;
    protected $table = 'invoice';
    protected $primaryKey = 'invoice_id';
    public $timestamps = true;

    protected $fillable = [
    	'invoice_no', 'invoice_date', 'due_date', 'customer_id', 'total_amount', 'term_id', 'transaction_id'
    ];

	public function transaction(){
		return $this->belongsTo(Transactions::class, 'transaction_id');
	}

	public function customer(){
		return $this->belongsTo(Customer::class, 'customer_id');
	}


    public function store(Request $request, $transactionId) {

    	$invoice = new Invoice();
    	$invoice->invoice_no = $request->invoice_no;
		$invoice->invoice_date = $request->invoice_date;
		$invoice->due_date = $request->due_date;
		$invoice->customer_id = $request->customer_id;
		$invoice->total_amount = $request->amount;
		$invoice->term_id = $request->term_id;
		$invoice->transaction_id = $transactionId;
        $invoice->save();

        if( $invoice->invoice_id ) {

            // prepare and insert transaction details
            $data['transactionDetails'] = [

                [
                    'transaction_id' => $transactionId,
                    'account_id' => $request->account_id,
                    'amount' => $request->amount,
                    'description' => NULL,
                    'person' => NULL,
                    'person_type' => NULL,
                    'to_increase' => 'debit'
                ], [
                    'transaction_id' => $transactionId,
                    'account_id' => $request->counter_account_id,
                    'amount' => $request->amount,
                    'description' => NULL,
                    'person' => NULL,
                    'person_type' => NULL,
                    'to_increase' => 'credit'
                ],

            ];

            // prepare and insert items details
            $jsonData = json_decode($request->input('items'));

            foreach ($jsonData as $key => $value) {
                    
                $data['itemDetails'][$key] = [

                    'item_id' => $value->item_id,
                    'description' => $value->description,
                    'qty' => $value->qty,
                    'rate' => $value->rate,
                    'amount' => $value->amount,
                    'transaction_id' => $transactionId

                ];
            }

            // insert transaction details and item details
            // add checker if successfuly created if not add another action
            TransactionDetails::insert($data['transactionDetails']);
            ItemDetail::insert($data['itemDetails']);

            return true;
        }

        return false;
    }

    // public function getTransactionId($invoiceId) {
    //     return Invoice::where('invoice_id', $invoiceId)->first()->transaction_id;
    // }

    public function checkInvoiceNo() {}
    public function generateInvoiceNo() {}

}
