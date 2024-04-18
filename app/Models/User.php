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
    public $with = ['personal_info', 'accessibilities.subModuleList', 'userBranch','userRole'];

    protected $fillable = [
        'username',
        'password',
        'salt',
        'status',
        'role_id',

    ];

    protected $hidden = [
        'password',
        'salt',
        'remember_token',
    ];


    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function personal_info()
    {
        return $this->hasOne(PersonalInfo::class, 'personal_info_id', 'personal_info_id');
    }

    public function userRole()
    {
        return $this->belongsTo(UserRole::class,'role_id','role_id');
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

    public function getUserBranch(array $attributes)
    {

        $user = User::where('username', '=', $attributes["username"])->with('userBranch', function ($query) use ($attributes) {
            $query->where('user_branch.branch_id', $attributes["branch_id"])->first();
        })->first();

        return $user;
    }

}
