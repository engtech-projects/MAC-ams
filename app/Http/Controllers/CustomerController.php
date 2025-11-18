<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\CustomerAddress;
use App\Http\Resources\Customer as CustomerResource;
use App\Http\Resources\CustomerCollection;
use Session;


class CustomerController extends MainController
{

	public function populate() {
		$customer = new Customer();
		return Customer::all();
        return new CustomerCollection($customer->customers());
		return response()->json(Customer::all(), 200);
    }

    public function index(Request $request){
		return view('sales.customers')->with([
			'title' 	=> 'Sales | Customers'.' - '.config('app.name'),
			'nav' 		=> ['sales', 'customers'],
			'customers' => Customer::with('addresses')->get(),
		]);
	}

	public function create(){
		return view('sales.create_customer')->with([
			'title' 	=> 'New Customer'.' - '.config('app.name'),
			'nav' 		=> ['sales', 'customers'],
		]);
	}

	public function edit(Request $request, $id){
		return view('sales.edit_customer')->with([
			'title'	=> 'Edit Customer Info'.' - '.config('app.name'),
			'nav' 	=> ['sales', 'customers'],
			'customer' => Customer::with('addresses')->find($id)
		]);
	}

	public function store(Request $request){
		$request->validate([
			'displayname' => ['required'],
		]);

		$customer = new Customer();
		$customer->firstname = $request->firstname;
		$customer->middlename = $request->middlename;
		$customer->lastname = $request->lastname;
		$customer->title = $request->title;
		$customer->suffix = $request->suffix;
		$customer->gender = $request->gender;
		$customer->displayname = $request->displayname;
		$customer->email_address = $request->email_address;
		$customer->mobile_number = $request->mobile_number;
		$customer->phone_number = $request->phone_number;
		$customer->tin_number = $request->tin;
		$customer->company = $request->company;
		$customer->birth_date = $request->birthdate;
		$customer->save();

		if($customer->customer_id){
			$address = new CustomerAddress();
			$address->street =  $request->bstreet;
			$address->city =  $request->bcity;
			$address->province =  $request->btown;
			$address->zip_code =  $request->bpostal_code;
			$address->country =  $request->bcountry;
			$address->customer_id =  $customer->customer_id;
			$address->address_type = 'billing address';
			$address->save();

			$saddress = new CustomerAddress();
			$saddress->street =  $request->sstreet;
			$saddress->city =  $request->scity;
			$saddress->province =  $request->stown;
			$saddress->zip_code =  $request->spostal_code;
			$saddress->country =  $request->scountry;
			$saddress->customer_id =  $customer->customer_id;
			$saddress->address_type = 'shipping address';
			$saddress->save();
		}
		Session::flash('success', 'Saved successfully!');
		return redirect(route('sales.customers'));
	}

	public function update(Request $request){
		$request->validate([
			'displayname' => ['required']
		]);

		$customer = Customer::with('addresses')->find($request->customer_id);
		$customer->firstname = $request->firstname;
		$customer->middlename = $request->middlename;
		$customer->lastname = $request->lastname;
		$customer->title = $request->title;
		$customer->suffix = $request->suffix;
		$customer->gender = $request->gender;
		$customer->displayname = $request->displayname;
		$customer->email_address = $request->email_address;
		$customer->mobile_number = $request->mobile_number;
		$customer->phone_number = $request->phone_number;
		$customer->tin_number = $request->tin;
		$customer->company = $request->company;
		$customer->birth_date = $request->birthdate;
		$customer->save();

		if($customer->billingAddress()->address_id){
			$address = CustomerAddress::find($customer->billingAddress()->address_id);
			$address->street =  $request->bstreet;
			$address->city =  $request->bcity;
			$address->province =  $request->btown;
			$address->zip_code =  $request->bpostal_code;
			$address->country =  $request->bcountry;
			$address->customer_id =  $customer->customer_id;
			$address->save();
		}
		if($customer->shippingAddress()->address_id){
			$saddress = CustomerAddress::find($customer->shippingAddress()->address_id);
			$saddress->street =  $request->sstreet;
			$saddress->city =  $request->scity;
			$saddress->province =  $request->stown;
			$saddress->zip_code =  $request->spostal_code;
			$saddress->country =  $request->scountry;
			$saddress->customer_id =  $customer->customer_id;
			$saddress->save();
		}
		Session::flash('success', 'Updated successfully!');
		return redirect(route('sales.customers'));
	}
}
