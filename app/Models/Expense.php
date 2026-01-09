<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Expense extends Model
{
    use HasFactory;

    protected $table = 'expense';
    protected $primaryKey = 'expense_id';
    public $timestamps = false;

    protected $fillable = [
    	'transaction_id', 'payment_method_id', 'payment_date', 'reference_no', 'payee', 'payee_type', 'total_amount', 'account_id', 'to_increase'
    ];

	public function supplier(){
		return $this->belongsTo(Supplier::class, 'payee');
	}

	public function transaction(){
		return $this->belongsTo(Transactions::class, 'transaction_id');
	}

	public function paymentMethod(){
		return $this->belongsTo(PaymentMethod::class, 'payment_method_id');
	}

    public function store(Request $request, $transactionId) {

    	$expense = new Expense();
    	$expense->transaction_id = $transactionId;
        $expense->payment_method_id = $request->payment_method_id;
        $expense->payment_date = $request->payment_date;
        $expense->reference_no = $request->reference_no;
        $expense->payee = $request->payee;
        $expense->payee_type = $request->payee_type;
        $expense->total_amount = $request->total_amount;
        $expense->account_id = $request->account_id;
        $expense->to_increase = 'credit';
        $expense->save();

        if( $expense->expense_id ){

            // prepare and insert items details
            $data= [];
            $jsonData = json_decode($request->input('items'));
            foreach ($jsonData as $key => $value) {
                        
                $data[$key] = [
                    'account_id' => $value->account_id,
                    'transaction_id' => $transactionId,
                    'amount' => $value->amount,
                    'description' => $value->description,
                    'person' => NULL,
                    'person_type' => NULL,
                    'to_increase' => $value->to_increase
                ];
            }

            TransactionDetails::insert($data);

            return true;
        }

        return false;
    }

    // public function 

    

}
