<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    use HasFactory;

    protected $table = "user_roles";
    protected $primary_key = "role_id";

    const BRANCH_MANAGER_ROLE = "Manager";

    public function users() {
        return $this->hasMany(User::class);
    }
}
