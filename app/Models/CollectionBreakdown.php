<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

use DB;

class CollectionBreakdown extends Model
{
    use HasFactory;

    const COLLECTION_GRP_ACCOUNT_OFFICER = "account_officer";
    const COLLECTION_FLAG = "P";

    protected $primaryKey = 'collection_id';
    protected $table = 'collection_breakdown';
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
    ];


    public function accountOfficerCollection()
    {
        return $this->hasMany(AccountOfficerCollection::class, 'collection_id');
    }

    public static function getCollectionById($id)
    {
        $collection = CollectionBreakdown::with(['accountOfficerCollection'])->where('collection_id', $id)->first();
        return $collection;
    }
    public static function getCollectionBreakdownByBranch($branchId)
    {
        return CollectionBreakdown::where('branch_id', $branchId)->get();
    }
    public function getCollectionByTransactionDate($transactionDate, $branchId)
    {

        $collection = CollectionBreakdown::whereDate('transaction_date','<', $transactionDate)
        ->where('branch_id',$branchId)
        ->orderBy('collection_id','DESC')
        ->first();
        return $collection;
    }

    public function createCollection(array $attributes)
    {
        $collection_ao = collect($attributes["collection_ao"])->map(function ($value) {
            $value["flag"] = CollectionBreakdown::COLLECTION_FLAG;
            $value["grp"] = CollectionBreakdown::COLLECTION_GRP_ACCOUNT_OFFICER;

            return $value;
        })->values();

        return DB::transaction(function () use ($attributes, $collection_ao) {
           self::create($attributes)->accountOfficerCollection()->createMany($collection_ao);
        });

    }

    public function getPreviousCollection($id)
    {
        $collection = $this->getCollectionById($id);
        $transactionDate = Carbon::createFromFormat('Y-m-d', $collection->transaction_date);

        $previousCollection = $this->getCollectionByTransactionDate($transactionDate, $collection->branch_id);
        return [
            'prev_transaction_date' => isset($previousCollection->transaction_date)?$previousCollection->transaction_date:'',
            'transaction_date' => $collection->transaction_date,
            'total' => isset($previousCollection->total) ? $previousCollection->total:0
        ];
    }

    public function getCollectionBreakdown($id)
    {
        $collections = $this->getCollectionById($id);
        return $collections;
    }

}
