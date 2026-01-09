<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

use DB;
use Illuminate\Support\Facades\Auth;

class CollectionBreakdown extends Model
{
    use HasFactory;

    protected $primaryKey = 'collection_id';
    protected $table = 'collection_breakdown';


    const COLLECTION_GRP_ACCOUNT_OFFICER = "account_officer";
    const COLLECTION_FLAG = "P";
    const BEGINNING_BAL = 54611;
    const UNPOSTED_STATUS = "unposted";


    public $timestamps = false;


    protected $fillable = [
        "p_1000",
        "p_500",
        "p_200",
        "p_100",
        "p_50",
        "p_20",
        "p_10",
        "p_5",
        "p_1",
        "c_25",
        "transaction_date",
        "branch_id",
        "total",
        "status",
        "flag"
    ];
    protected static $recordEvents = ['deleted', 'created', 'updated'];


    public function getModelName()
    {

        return class_basename($this);
    }

    public function account_officer_collections()
    {
        return $this->hasMany(AccountOfficerCollection::class, 'collection_id');
    }
    public function pos_collections()
    {
        return $this->hasMany(PosCollection::class, 'collection_id');
    }



    public function branch_collections()
    {

        return $this->hasMany(BranchCollection::class, 'collection_id');
    }

    public function other_payment()
    {
        return $this->belongsTo(OtherPayment::class, 'collection_id', 'collection_id');
    }


    public static function getCollectionById($id)
    {
        $collection = CollectionBreakdown::with(['account_officer_collections', 'branch_collections.branch', 'other_payment', 'pos_collections'])->where('collection_id', $id)->first();
        return $collection;
    }
    public static function getCollectionBreakdownByBranch($transactionDate, $branchId = null, $perPage = 15)
    {
        $query = CollectionBreakdown::with([
            'account_officer_collections', 
            'branch_collections.branch', 
            'other_payment',
            'pos_collections'
        ])
        ->when($branchId, function ($query, $branchId) {
            $query->where('branch_id', $branchId);
        })
        ->when($transactionDate, function ($query, $transactionDate) {
            $query->where('transaction_date', $transactionDate);
        }, function ($query) {
            $query->where('transaction_date', '>=', '2024-01-01');
        })
        ->orderBy('transaction_date', 'desc');
        $collections = $query->paginate($perPage);
        $journalEntry = new journalEntry();
        foreach ($collections->items() as $collection) {
            $cashEndingBalance = $journalEntry->getCashEndingBalanceByBranch(
                $collection->branch_id, 
                $collection->transaction_date
            );
            $collection->cash_ending_balance = $cashEndingBalance;
            $aoTotal = $collection->account_officer_collections->sum('total');
            $branchTotal = $collection->branch_collections->sum('total_amount');
            $posTotal = $collection->pos_collections->sum('total_amount');
            $checkAmount = $collection->other_payment->check_amount ?? 0;
            $memoAmount = $collection->other_payment->memo_amount ?? 0;
            
            $collection->total = $aoTotal + $branchTotal + $posTotal + $checkAmount + $memoAmount;
        }
        return $collections;
    }
    public static function getCollections($transactionDate, $branchId = null)
    {
        return CollectionBreakdown::when($branchId, function ($query, $branchId) {
            $query->where('branch_id', $branchId);
        })
            ->when($transactionDate, function ($query, $transactionDate) {
                $query->where('transaction_date', $transactionDate);
            }, function ($query) {
                // If no transaction date is provided, filter from 2024-01-01 onwards
                $query->where('transaction_date', '>=', '2024-01-01');
            })
            ->orderBy('transaction_date', 'desc')
            ->get();
    }
    public function getCollectionByTransactionDate($transactionDate, $branchId)
    {

        $collection = CollectionBreakdown::whereDate('transaction_date', '<', $transactionDate)
            ->where('branch_id', $branchId)
            ->orderBy('transaction_date', 'DESC')
            ->first();
        return $collection;
    }

    public function createCollection(array $attributes)
    {
        $collection_ao = collect($attributes["account_officer_collection"])->map(function ($value) {
            $value["flag"] = CollectionBreakdown::COLLECTION_FLAG;
            $value["grp"] = CollectionBreakdown::COLLECTION_GRP_ACCOUNT_OFFICER;
            return $value;
        })->values();

        return DB::transaction(function () use ($attributes, $collection_ao) {
            $collection = self::create($attributes);
            $collection->account_officer_collections()->createMany($collection_ao);
            $collection->branch_collections()->createMany($attributes['branch_collections']);
            $collection->other_payment()->create($attributes['other_payment']);
        });
    }

    public function getPreviousCollection($id)
    {
        $collection = $this->getCollectionById($id);
        $transactionDate = Carbon::createFromFormat('Y-m-d', $collection->transaction_date);
        $previousCollection = $this->getCollectionByTransactionDate($transactionDate, $collection->branch_id);
        return [
            'prev_transaction_date' => isset($previousCollection->transaction_date) ? $previousCollection->transaction_date : '',
            'transaction_date' => $collection->transaction_date,
            'total' => isset($previousCollection->total) ? $previousCollection->total : 0
        ];
    }

    public function getCollectionBreakdown($id)
    {
        $collections = $this->getCollectionById($id);
        return $collections;
    }

    public function deleteCollection($collection) {}
}
