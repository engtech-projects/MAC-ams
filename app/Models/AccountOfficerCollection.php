<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountOfficerCollection extends Model
{
    use HasFactory;


    protected $table = 'collection_ao';
    protected $primaryKey = 'collection_ao_id';
    public $timestamps = false;

    protected $fillable = [
        'collection_id',
        'representative',
        'grp',
        'note',
        'total'
    ];

    public function collection()
    {
        return $this->belongsTo(CollectionBreakdown::class,'collection_id');

    }
}
