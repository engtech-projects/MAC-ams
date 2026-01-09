<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountOfficer extends Model
{
    use HasFactory;

    protected $primaryKey = 'accountofficer_id';
    protected $table = 'account_officer';

    /* protected $primaryKey = 'accountofficer_id';
    protected $table = 'account_officer';

    protected $fillable = [
        'officer_fname',
        'officer_mname',
        'tofficer_lname',
        'officer_address',
    ];*/

    public static function fetchAccountOfficer() {
        $account_officer = AccountOfficer::all();
        return $account_officer;
    }
    public static function getAccountOfficerByBranchId($branch_id) {
        $data = AccountOfficer::where('branch_id','=',$branch_id)->get();
        return $data;
    }

}
