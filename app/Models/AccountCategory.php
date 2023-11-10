<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountCategory extends Model
{
    use HasFactory;

    const REVENUE_TYPE = 4;
    const EXPENSE_TYPE = 5;

    protected $table = 'account_category';
    protected $primaryKey = 'account_category_id';

    protected $fillable = ['account_category'];


    public function accountType()
    {
        return $this->hasMany(AccountType::class);
    }


}
