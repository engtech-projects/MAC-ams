<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonalInfo extends Model
{
    use HasFactory;

    protected $table = 'personal_info';
    protected $primaryKey = 'personal_info_id';

    protected $fillable = [
    	'fname',
    	'mname',
    	'lname',
    	'gender',
    	'displayname',
    	'email_address',
    	'phone_number',
    ];
	public function userInfo(){
		return $this->hasOne(User::class, 'personal_info_id');
    }
}
