<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class SubsidiaryCategory extends Model
{
    use HasFactory;

    protected $table = 'subsidiary_category';
    protected $primaryKey = 'sub_cat_id';

    const INSUR = 'INSUR';
    const SUPPLY = 'SUPLY';
    const AMORT = 'AMORT';
    const DEPRE = 'DEPRE';
    const INSUR_ADD = 'INSUR-ADD';
    const ADDTIONAL_PREPAID_EXP = 'Additional Prepaid Expense';
    const LEASE = "LEASE";

    protected $fillable = [
        'sub_cat_name',
        'sub_cat_type',
        'description',
        'sub_cat_code'
    ];
    protected static $recordEvents = ['deleted', 'created', 'updated'];
    public function getModelName()
    {

        return class_basename($this);
    }

    public function accounts()
    {
        return $this->belongsToMany(Accounts::class, 'subsidiary_category_accounts', 'sub_cat_id', 'account_id')
            ->withPivot('transaction_type');
    }

    public function subsidiaries()
    {
        return $this->hasMany(Subsidiary::class, 'sub_cat_id');
    }
}
