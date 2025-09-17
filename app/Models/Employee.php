<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
	protected $primaryKey = "employee_id";

	public function address(){
		return $this->hasOne(EmployeeAddress::Class, 'employee_id');
	}

	public function withEdit(){
		$this->edit = route('employee.edit',['id'=>$this->employee_id]);
		return $this;
	}

	public function withAge(){
		$this->age = age($this->birth_date);
		return $this;
	} 
}
