<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductsServices extends Model
{
    use HasFactory;
	protected $primaryKey = "item_id";
	protected $table = "products_and_services";

	public function itemDetails(){
		return $this->hasOne(ItemDetail::class, 'item_id');
	}

	public function category(){
		return $this->belongsTo(ProductsServicesCategory::class, 'ps_category_id');
	}

	public function withEdit(){
		if($this->type == 'product'){
			$this->edit = route('product.edit', ['id'=>$this->item_id]);
		}else{
			$this->edit = route('service.edit', ['id'=>$this->item_id]);
		}		
		return $this;
	}

	public function withCopy(){
		if($this->type == 'product'){
			$this->copy = route('product.create', ['id'=>$this->item_id]);
		}else{
			$this->copy = route('service.create', ['id'=>$this->item_id]);
		}		
		return $this;
	}

	public function withImage(){
		if(empty($this->image_path)){
			$this->img = asset('img/img_temp.png');
		}else{
			$this->img = asset($this->image_path);
		}		
		return $this;
	}
}
