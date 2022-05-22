<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JournalBook extends Model
{
    use HasFactory;

    protected $table = 'journal_book';
    protected $primaryKey = 'book_id';

    protected $fillable = [
    	'book_code',
    	'book_name',
    	'book_src',
    	'book_ref',
    	'book_head',
    	'book_flag',
    ];

}
