<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\SubModuleList;


class Accessibilities extends Model
{
    use HasFactory;

    protected $table = 'accessibilities';
    protected $primaryKey = 'access_id';
    protected $fillable = ['user_id', 'sml_id', 'date_created'];


    public function subModuleList()
    {
        return $this->belongsTo(subModuleList::class, 'sml_id');
    }


}
