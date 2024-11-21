<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CollectionBreakdown;
use App\Models\journalEntry;
use Illuminate\Http\Request;

class CollectionBreakdownController extends Controller
{

    public function index()
    {
        //
    }
    public function show(CollectionBreakdown $collectionBreakdown)
    {
        $journalEntries = new journalEntry();
        $cashTransactionsEntries = $journalEntries->getCashBlotterEntries($collectionBreakdown->collection_id, $collectionBreakdown->branch_id);
        return response()->json(['data' => $cashTransactionsEntries]);
    }
    public function store(Request $request)
    {
        //
    }
    public function update(Request $request, CollectionBreakdown $collectionBreakdown)
    {
        $data = $request->validated([
            "total" => 'numeric',
            'collection_id' => 'required|numeric',
            'branch_id' => 'required|numeric',
            'transaction_date' => 'date_format:yyyy-mm-dd',
            'p_1000' => 'numeric',
            'p_500' => 'numeric',
            'p_200' => 'numeric',
            'p_100' => 'numeric',
            'p_50' => 'numeric',
            'p_20' => 'numeric',
            'p_10' => 'numeric',
            'p_5' => 'numeric',
            'p_1' => 'numeric',
            'c_25' => 'numeric',
            'total' => 'numeric',
            'flag' => 'string|nullable',
            'staus' => 'string|required',
            'account_officer_collection' => 'required|array'
        ]);

        try {
            $collectionBreakdown->update($data);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ]);
        }
        return response()->json(['message' => 'Successfully updated.']);
    }
    public function destroy(CollectionBreakdown $collectionBreakdown)
    {
        try {
            $collectionBreakdown->delete();
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
        }

        return response()->json(['message' => 'Deleted successfully.']);
    }
}
