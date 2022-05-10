<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Models\Accounts;

class TransactionDetails extends Model
{
    use HasFactory;

    protected $table = 'transaction_details';
    protected $primaryKey = 'transaction_details_id';
    public $timestamps = false;

    protected $fillable = [
    	'account_id', 'transaction_id', 'amount', 'description', 'person', 'person_type', 'to_increase'
    ];


    public static function getDetails($transactionId) {

    	$details = TransactionDetails::join('chart_of_accounts', 'transaction_details.account_id', '=', 'chart_of_accounts.account_id')
    					->select(
    						'transaction_details.*',
    						'chart_of_accounts.account_name'
    					)
    					->where('transaction_details.transaction_id', $transactionId)
    					->get();

    	return $details;
    }

	public function user(){
		return $this->belongsTo(TransactionDetails::class, 'transaction_id');
	}

}
