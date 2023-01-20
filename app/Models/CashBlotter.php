<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CashBlotter extends Model
{
    use HasFactory;

    protected $primaryKey = 'cashblotter_id';
    protected $table = 'cash_blotter';

    protected $fillable = [
        'transaction_date',
        'total_collection',
        'branch_id'
    ];


    public static function fetchCashBlotter() {
        $cashblotter =CashBlotter::leftjoin("branch", 'branch.branch_id','=','cash_blotter.branch_id')
        ->select("cash_blotter.*","branch.*")
        ->get();
        return $cashblotter;
    }
    public static function fetchCashBlotterById($cashblotter_id) {
        $cashblotter = $branch = CashBlotter::leftjoin("branch", 'branch.branch_id','=','cash_blotter.branch_id')
        ->select("branch.*","cash_blotter.*")
        ->where('cash_blotter.cashblotter_id','=',$cashblotter_id)
        ->first();
        return $branch;
        return $cashblotter;
    }



}
