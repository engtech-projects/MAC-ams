<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class CollectionBreakdown extends Model
{
    use HasFactory;

    protected $primaryKey = 'collection_id';
    protected $table = 'collection_breakdown';

    public static function getCollectionById($id)
    {
        $collection = CollectionBreakdown::find($id);
        return $collection;
    }
    public static function getCollectionBreakdownByBranch($branchId)
    {
        return CollectionBreakdown::where('branch_id', $branchId)->get();
    }
    public function getCollectionByTransactionDate($transactionDate, $branchId)
    {
        $collection = CollectionBreakdown::where('branch_id', $branchId)->whereDate('transaction_date', '=', $transactionDate)->first();
        return $collection;
    }

    public function getPreviousCollection($id)
    {
        $collection = $this->getCollectionById($id);
        $transactionDate = Carbon::createFromFormat('Y-m-d', $collection->transaction_date);
        $prevTransactionDate = Carbon::parse($transactionDate)->subDay();
        $previousCollection = $this->getCollectionByTransactionDate($prevTransactionDate, $collection->branch_id);
        return [
            'prev_transaction_date' => $previousCollection->transaction_date,
            'transaction_date' => $collection->transaction_date,
            'total' => $previousCollection->total
        ];
    }
}
