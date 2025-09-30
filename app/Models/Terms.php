<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Terms extends Model
{
    use HasFactory;
    protected $primaryKey = "term_id";
	protected $table = "payment_terms";

	protected $fillable = [
    	'term', 'no_of_days'
    ];
}
