<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PosCollection extends Model
{
    protected $table = 'pos_collections';
    protected $primaryKey = 'id';
    protected $fillable = [
        'collection_id',
        'total_amount',
        'or_no'
    ];
    use HasFactory;
}