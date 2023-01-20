<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BranchCollection extends Model
{
    use HasFactory;

    protected $table = "branch_collection";
    protected $primaryKey = "branchcollection_id";

    protected $fillable = [
        'total_amount',
        'cashblotter_id',
        'sub_id'
    ];
}
