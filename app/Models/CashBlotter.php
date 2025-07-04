<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CashBlotter extends Model
{
    use HasFactory;
    use LogsActivity;

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

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->setDescriptionForEvent(fn(string $eventName) => $eventName)
            ->useLogName('Cash Blotter');
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
