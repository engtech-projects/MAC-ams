<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subsidiary extends Model
{
    use HasFactory;

    protected $table = 'subsidiary';
    protected $primaryKey = 'sub_id';

    protected $fillable = [
    	'sub_cat_id',
    	'sub_name',
    	'sub_address',
    	'sub_tel',
    	'sub_acct_no',
    	'sub_per_branch',
    	'sub_date',
    	'sub_amount',
    	'sub_no_depre',
    	'sub_no_amort',
    	'sub_life_used',
    	'sub_salvage',
    	'sub_date_post'
    ];

	public function subsidiaryCategory(){
		return $this->belongsTo(SubsidiaryCategory::class, 'sub_cat_id');
    }

}
