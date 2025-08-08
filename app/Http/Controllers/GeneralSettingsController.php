<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\CompanyAddress;
use App\Models\Currency;
use App\Models\Accounting;
use Session;
use DB;

class GeneralSettingsController extends MainController
{
    public function index(){
		return view('settings.index')->with([
			'title' 	=> 'General Settings'.' - '.config('app.name'),
			'nav' 		=> ['settings', 'general'],
			'company' 	=> Company::with('address')->first(),
			'currencies' => Currency::all(),
			'accounting' => Accounting::first()
		]);
	}

	public function companyUpdate(Request $request){
		$company = null;
		$address = null;
		if(!Company::first()){
			$company = new Company;
		}else {
			$company = Company::first();
		}
		$company->logo = '';
		$company->company_name = $request->company_name;
		$company->company_email = $request->company_email;
		$company->phone_number = $request->phone_number;
		$company->contact_number = $request->contact_number;
		$company->save();

		if(!CompanyAddress::first()){
			$address = new CompanyAddress;
		}else {
			$address = CompanyAddress::first();
		}

		$address->street = $request->address;
		$address->city = $request->city;
		$address->province = $request->town;
		$address->zip_code = $request->postal_code;
		$address->country = $request->country;
		$address->company_id = $company->company_id;
		$address->save();

		Session::flash('success', 'Company info updated successfully.');
		return redirect(route('settings.general'));
	}

	public function accountingUpdate(Request $request){
		$accounting = null;
		if(!Accounting::first()){
			$accounting = new Accounting;
		}else {
			$accounting = Accounting::first();
		}
		$accounting->start_date = $request->start_date;
		$accounting->end_date = $request->end_date;
		$accounting->method = $request->method;
		$accounting->save();

		Session::flash('success', 'Accounting info updated successfully.');
		return redirect(route('settings.general'));
	}

	public function currencyUpdate(Request $request){
		$currency = Currency::find($request->currency);
		Currency::where('status', '=', 'active')->update(['status' => '']);
		$currency->status = 'active';
		$currency->save();

		Session::flash('success', 'Currency updated successfully.');
		return redirect(route('settings.general'));
	}
}
