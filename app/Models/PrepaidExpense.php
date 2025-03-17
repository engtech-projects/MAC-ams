<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrepaidExpense extends Model
{
    use HasFactory;
    protected $table = 'prepaid_expenses';
    protected $primaryKey = 'id';
    protected $fillable = [
        'amount',
        'sub_id',
        'created_at',
        'updated_at',
    ];


    public function subsidiary()
    {
        return $this->belongsTo(Subsidiary::class, 'sub_id');
    }
}
