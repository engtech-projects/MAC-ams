<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class ItemDetail extends Model
{
    use HasFactory;
    protected $table = 'item_details';
	protected $primaryKey = 'item_id';
    public $timestamps = false;

    protected $fillable = [
    	'item_id', 'description', 'qty', 'rate', 'amount', 'transaction_id'
    ];

	public function item(){
		return $this->belongsTo(ProductsAndServices::class, 'item_id');
	}

}
