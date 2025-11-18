<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;
	protected $primaryKey = "company_id";
	protected $table = "company";

	public function address(){
		return $this->hasOne(CompanyAddress::class, 'company_id');
	}
}
