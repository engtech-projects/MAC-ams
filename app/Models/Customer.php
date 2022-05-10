<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Transactions;

class Customer extends Model
{
    use HasFactory, HasApiTokens;
	protected $primaryKey = "customer_id";
	protected $table = "customer";

	public function customers() {

		$transactions = new Transactions();
		$customers = Customer::all();

		foreach ($customers as $key => $value) {
			$value->open_balance = 0.00;
			$value->unpaid = $transactions->invoice(['customer' => $value->customer_id, 'status' => 'open', 'dateRange' => NULL]);
		}

		return $customers;
	}

	public function addresses(){
		return $this->hasMany(CustomerAddress::Class, 'customer_id');
	}

	public function billingAddress(){
		foreach ($this->addresses as $key => $address) {
			if($address->address_type == 'billing address'){
				return $address;
			}
		}
		return null;
	}
	public function shippingAddress(){
		foreach ($this->addresses as $key => $address) {
			if($address->address_type == 'shipping address'){
				return $address;
			}
		}
		return null;
	}
}
