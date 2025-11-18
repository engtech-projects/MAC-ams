<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductsAndServices extends Model
{
    use HasFactory;
    protected $primaryKey = "item_id";
	protected $table = "products_and_services";

}
