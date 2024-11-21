<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BranchCollection extends Model
{
    use HasFactory;

    protected $table = "branch_collection";

    protected $fillable = [
        'collection_id',
        'total_amount',
    ];
}
