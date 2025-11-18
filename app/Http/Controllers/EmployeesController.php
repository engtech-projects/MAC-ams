<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\EmployeeAddress;
use Session;

class EmployeesController extends MainController
{
	public function index(){
		return view('employees.list')->with([
			'title'	=> 'Employees | List of Employees'.' - '.config('app.name'),
			'nav' 	=> ['employees', 'list'],
			'employees' => Employee::with('address')->orderBy('displayname', 'ASC')->get(),
		]);
	}

	public function employeesDataTable(){
		$employees = (new Employee())->orderBy('displayname', 'ASC')->get();
		foreach ($employees as $key => $value) {
			$value->withEdit();
			$value->withAge();
		}
		return $employees;
	}

    public function create(Request $request){
		return view('employees.create')->with([
			'title'	=> 'Employees | Create New Employee'.' - '.config('app.name'),
			'nav' 	=> ['employees', 'create']
		]);
	}

	public function edit(Request $request, $id){
		return view('employees.edit')->with([
			'title'	=> 'Employees | Edit Employee'.' - '.config('app.name'),
			'nav' 	=> ['employees', 'edit'],
			'employee' => Employee::with('address')->find($id)
		]);
	}

	public function update(Request $request){
		$request->validate([
			'firstname' => ['required'],
			'middlename' => ['required'],
			'lastname' => ['required'],
			'displayname' => ['required']
		]);

		$employee = Employee::with('address')->find($request->employee_id);
		$employee->firstname = $request->firstname;
		$employee->middlename = $request->middlename;
		$employee->lastname = $request->lastname;
		$employee->gender = $request->gender;
		$employee->displayname = $request->displayname;
		$employee->email_address = $request->email_address;
		$employee->mobile_number = $request->mobile_number;
		$employee->phone_number = $request->phone_number;
		$employee->employee_id_no = $request->employee_id_no;
		$employee->birth_date = $request->birthdate;
		$employee->save();

		if($employee->address->address_id){
			$address = EmployeeAddress::find($employee->address->address_id);
			$address->street =  $request->address;
			$address->city =  $request->city;
			$address->province =  $request->town;
			$address->zip_code =  $request->postal_code;
			$address->country =  $request->country;
			$address->employee_id =  $employee->employee_id;
			$address->save();
		}
		Session::flash('success', 'Updated successfully!');
		return redirect(route('employees'));
	}

	public function store(Request $request){
		$request->validate([
			'firstname' => ['required'],
			'middlename' => ['required'],
			'lastname' => ['required'],
			'displayname' => ['required']
		]);

		$employee = new Employee();
		$employee->firstname = $request->firstname;
		$employee->middlename = $request->middlename;
		$employee->lastname = $request->lastname;
		$employee->gender = $request->gender;
		$employee->displayname = $request->displayname;
		$employee->email_address = $request->email_address;
		$employee->mobile_number = $request->mobile_number;
		$employee->phone_number = $request->phone_number;
		$employee->employee_id_no = $request->employee_id_no;
		$employee->birth_date = $request->birthdate;
		$employee->save();

		if($employee->employee_id){
			$address = new EmployeeAddress();
			$address->street =  $request->address;
			$address->city =  $request->city;
			$address->province =  $request->town;
			$address->zip_code =  $request->postal_code;
			$address->country =  $request->country;
			$address->employee_id =  $employee->employee_id;
			$address->save();
		}
		Session::flash('success', 'Saved successfully!');
		return redirect(route('employees'));
	}
}
