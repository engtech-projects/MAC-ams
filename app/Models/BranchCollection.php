<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BranchCollection extends Model
{
    use HasFactory;

    protected $table = "branch_collections";

    protected $fillable = [
        'collection_id',
        'total_amount',
        'branch_id'
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id', 'branch_id');
    }
}
