<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Models\TransactionDetails;
use App\Models\Invoice;
use App\Models\Transactions;
use App\Models\Bill;

class Payment extends Model
{
    use HasFactory;

    protected $table = 'payment';
    protected $primaryKey = 'payment_id';

    public $timestamps = false;

    protected $fillable = [
    	'payment_method_id', 'payment_date', 'reference_no', 'amount', 'transaction', 'reference_id', 'transaction_id'
    ];


    public function store(Request $request, $transactionId) {

    	$payment = new Payment();
    	$payment->payment_method_id = $request->payment_method_id;
		$payment->payment_date = $request->payment_date;
		$payment->reference_no = $request->reference_no;
		$payment->amount = $request->amount;
		$payment->transaction = $request->transaction;
		$payment->reference_id = $request->reference_id;
		$payment->transaction_id = $transactionId;
		$payment->save();

		if( $payment->payment_id ){

			$data = [

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
                    'account_id' => $request->default_account,
                    'amount' => $request->amount,
                    'description' => NULL,
                    'person' => NULL,
                    'person_type' => NULL,
                    'to_increase' => 'credit'
	            ],

			];

			TransactionDetails::insert($data);

			if( $request->status == 'closed' ){
				$invoice = Invoice::where('invoice_id', $payment->reference_id)->first();
				$transaction = Transactions::find($invoice->transaction_id);
				$transaction->status = 'paid';
				$transaction->save();
			}

			return true;
		}
		return false;
    }

    public static function getBalanceFromInvoice($invoiceId) {

    	$invoice = Invoice::find($invoiceId);
    	$payment = Payment::where(['reference_id' => $invoiceId, 'transaction' => 'invoice' ])->get();

    	$total = floatval($invoice->total_amount);
    	$totalPayment = 0;
    	
    	foreach ($payment as $key => $value) {
    		$totalPayment += floatval($value->amount);
    	}
    	
    	return $total - $totalPayment;
    }

    public static function getBalanceFromBill($billId) {}

}
