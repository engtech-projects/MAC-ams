<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;

    protected $table = 'branch';
    protected $primaryKey = 'branch_id';

    public function userBranch()
    {
        return $this->belongsToMany(User::class,'user_branch','user_id','branch_id');
    }

    public static function fetchBranch()
    {
        return Branch::all();
    }

}
