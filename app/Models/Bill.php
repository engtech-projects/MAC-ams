<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Bill extends Model
{
    use HasFactory;

    protected $table = 'bill';
    protected $primaryKey = 'bill_id';
    public $timestamps = false;

    protected $fillable = [
    	'bill_no', 'bill_date', 'due_date', 'payee', 'payee_type', 'total_amount', 'term_id', 'transaction_id', 'account_id', 'to_increasse'
    ];

    public function store(Request $request, $transactionId) {

    	$bill = new Bill();
    	$bill->bill_no = $request->bill_no;
        $bill->bill_date = $request->bill_date;
        $bill->due_date = $request->due_date;
        $bill->payee = $request->payee;
        $bill->payee_type = $request->payee_type;
        $bill->total_amount = $request->total_amount;
        $bill->term_id = $request->term_id;
        $bill->transaction_id = $transactionId;
        $bill->account_id = $request->account_id;
        $bill->to_increase = 'credit';
        $bill->save();

        if( $bill->bill_id ){

            // 
            // $data['transactionDetails'] = [
            //     'account_id' => $request->account_id,
            //     'transaction_id' => $transactionId,
            //     'amount' => $request->total_amount,
            //     'description' => NULL,
            //     'person' => $request->payee,
            //     'person_type' => $request->payee_type,
            //     'to_increase' => 'credit'
            // ];

            // TransactionDetails::insert($data['transactionDetails']);
            // 
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
}
