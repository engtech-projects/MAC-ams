<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubsidiaryCategory extends Model
{
    use HasFactory;

    protected $table = 'subsidiary_category';
    protected $primaryKey = 'sub_cat_id';

    protected $fillable = [
        'sub_cat_name',
        'sub_cat_type',
        'description'
    ];

    public function accounts()
    {
        return $this->belongsToMany(Accounts::class, 'subsidiary_category_accounts', 'sub_cat_id', 'account_id');
    }
}
