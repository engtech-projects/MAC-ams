<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierAddress extends Model
{
    protected $primaryKey = "address_id";
	protected $table = "supplier_address";
	public $timestamps = true;

	protected $fillable = [
    	'street', 'city', 'province', 'zip_code', 'country', 'supplier_id'
    ];
    
}
