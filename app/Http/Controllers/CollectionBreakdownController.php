<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateOrUpdateCollectionRequest;
use App\Models\BranchCollection;
use App\Models\CollectionBreakdown;
use App\Models\journalEntry;
use Illuminate\Http\JsonResponse;
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
    public function store(CreateOrUpdateCollectionRequest $request)
    {


        $attributes = $request->validated();
        $collection_ao = collect($attributes["account_officer_collections"])->map(function ($value) {
            $value["grp"] = CollectionBreakdown::COLLECTION_GRP_ACCOUNT_OFFICER;
            return $value;
        })->values();
        try {
            $collection = CollectionBreakdown::create($attributes);
            $attributes['other_payment']['collection_id'] = $collection->collection_id;
            $collection->other_payment()->create($attributes['other_payment']);
            $collection->account_officer_collections()->createMany($collection_ao);
            foreach ($attributes['branch_collections'] as $bc) {
                $collection->branch_collections()->create([
                    "total_amount" => $bc["total"],
                    "branch_id" => $bc["branch"]["branch_id"],
                ]);
            }
        } catch (\Exception $exception) {
            return new JsonResponse(["message" => $exception->getMessage()]);
        }
        return new JsonResponse(["message" => "Collection successfully saved."]);
    }
    public function update(CreateOrUpdateCollectionRequest $request, CollectionBreakdown $collectionBreakdown)
    {
        $data = $request->validated();
        try {
            $collectionBreakdown->update($data);
            foreach ($data["branch_collections"] as $bc) {
                $BranchCollection = BranchCollection::find($bc["id"])->update([
                    "total_amount" => $bc["total_amount"],
                    "branch_id" => $bc["branch"]["branch_id"],

                ]);
                if (!$BranchCollection) {
                    BranchCollection::create([
                        "total_amount" => $bc["total_amount"],
                        "branch_id" => $bc["branch_id"]
                    ]);
                }
            }
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
