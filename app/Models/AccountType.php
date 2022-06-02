<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountType extends Model
{
    use HasFactory;

    protected $table = 'account_type';
    protected $primaryKey = 'account_type_id';
    public $timestamps = true;

    protected $fillable = [
    	'account_no', 'account_type', 'has_opening_balance', 'account_category_id'
    ];

	public function accountCategory(){
		return $this->hasMany(AccountCategory::class, 'account_category_id');
    }
}
