<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;
use App\Models\PersonalInfo;
use App\Models\Accessibilities;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    public $with = ['personal_info', 'accessibilities.subModuleList', 'userBranch'];

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'username',
        'password',
        'salt',
        'status',
        'role_id',

    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'salt',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function personal_info()
    {
        return $this->hasOne(PersonalInfo::class, 'personal_info_id');
    }

    public function userBranch()
    {
        return $this->belongsToMany(Branch::class, 'user_branch', 'user_id', 'branch_id');
    }

    public function accessibilities()
    {
        return $this->hasMany(Accessibilities::class, 'user_id');
    }
    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }

    public function getUserByUsername(array $attribules)
    {
        $user = User::where('username','=', $attribules["username"])->with('userBranch',function($query) use($attribules){
            $query->where('user_branch.branch_id',$attribules["branch_id"]);
        })->first();
        return $user;
    }

}
