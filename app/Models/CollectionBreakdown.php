<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CollectionBreakdown extends Model
{
    use HasFactory;

    protected $primaryKey = 'collection_id';
    protected $table = 'collection_breakdown';

    public static function getCollectionBreakdownById($id)
    {
        $collectionBreakdown = CollectionBreakdown::find($id);
        return $collectionBreakdown;
    }
}
