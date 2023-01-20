<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountOfficerCollection extends Model
{
    use HasFactory;


    protected $table = 'ao_collection';
    protected $primaryKey = 'aocollection_id';

    protected $fillable = [
        'remarks',
        'total_amount',
        'accountofficer_id',
        'cashblotter_id'
    ];
}
