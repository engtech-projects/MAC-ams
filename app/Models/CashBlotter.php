<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
    protected static $recordEvents = ['deleted', 'created', 'updated'];
    public function getModelName()
    {

        return class_basename($this);
    }

    public static function fetchCashBlotter()
    {
        $cashblotter = CashBlotter::leftjoin("branch", 'branch.branch_id', '=', 'cash_blotter.branch_id')
            ->select("cash_blotter.*", "branch.*")
            ->get();
        return $cashblotter;
    }

    public static function fetchCashBlotterById($cashblotter_id)
    {
        $branch = CashBlotter::leftjoin("branch", 'branch.branch_id', '=', 'cash_blotter.branch_id')
            ->select("branch.*", "cash_blotter.*")
            ->where('cash_blotter.cashblotter_id', '=', $cashblotter_id)
            ->first();
        return $branch;
    }
}