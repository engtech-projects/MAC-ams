<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubsidiaryOpeningBalance extends Model
{
    use HasFactory;
    protected $table = 'subsidiary_opening_balance';
    protected $primaryKey = 'id';
}
