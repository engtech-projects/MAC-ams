<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\SubModuleList;


class AccessList extends Model
{
    use HasFactory;

    protected $table = 'access_lists';
    protected $primaryKey = 'al_id';
    protected $fillable = [

    ];


	public function sub_module_list(){
		return $this->hasMany(subModuleList::class, 'al_id');
    }

}
