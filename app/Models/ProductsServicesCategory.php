<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductsServicesCategory extends Model
{
    use HasFactory;
	protected $primaryKey = "ps_category_id";
	protected $table = "products_services_category";
}
