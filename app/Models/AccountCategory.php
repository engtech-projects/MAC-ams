<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountCategory extends Model
{
    use HasFactory;

    protected $table = 'account_category';
    protected $primaryKey = 'account_category_id';

    protected $fillable = ['account_category'];
}
