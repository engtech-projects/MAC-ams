<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class SubModuleList extends Model
{
    use HasFactory;

    protected $table = 'sub_module_lists';
    protected $primaryKey = 'sml_id';
    protected $fillable = [

    ];

}
