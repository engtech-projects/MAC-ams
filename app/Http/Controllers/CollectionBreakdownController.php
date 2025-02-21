<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateOrUpdateCollectionRequest;
use App\Models\AccountOfficerCollection;
use App\Models\BranchCollection;
use App\Models\CollectionBreakdown;
use App\Models\journalEntry;
use App\Models\OtherPayment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $otherPayment = $collectionBreakdown->other_payment;
        if (!$otherPayment) {
            $cashTransactionsEntries['collections']['other_payment'] = [
                'cash_amount' => 0,
                'check_amount' => 0,
                'memo_amount' => 0,
                'pos_amount' => 0,
                'interbranch_amount' => 0,
            ];
        }
        return response()->json(['data' => $cashTransactionsEntries]);
    }
    public function store(CreateOrUpdateCollectionRequest $request)
    {
        $attributes = $request->validated();
        $collection_ao = collect($attributes["account_officer_collections"])->map(function ($value) {
            $value["grp"] = CollectionBreakdown::COLLECTION_GRP_ACCOUNT_OFFICER;
            return $value;
        })->values();
        $unposted = CollectionBreakdown::where(['status' => CollectionBreakdown::UNPOSTED_STATUS, 'branch_id' => $attributes['branch_id']])->orderBy('collection_id', 'DESC')->first();
        if ($unposted) {
            return new JsonResponse(["message" => "Failed to save transaction. There is transaction that need to post."], 400);
        } else {
            try {
                DB::beginTransaction();
                $collection = CollectionBreakdown::create($attributes);
                $attributes['other_payment']['collection_id'] = $collection->collection_id;
                $collection->other_payment()->create($attributes['other_payment']);
                $collection->account_officer_collections()->createMany($collection_ao);
                foreach ($attributes['branch_collections'] as $bc) {
                    $collection->branch_collections()->create([
                        "total_amount" => $bc["total_amount"],
                        "branch_id" => $bc["branch"]["branch_id"],
                    ]);
                }
                foreach ($attributes['pos_collections'] as $pc) {
                    $collection->pos_collections()->create([
                        "total_amount" => $pc["total_amount"],
                        "or_no" => $pc["or_no"],
                    ]);
                }
                DB::commit();
            } catch (\Exception $exception) {
                DB::rollBack();
                return new JsonResponse(["message" => $exception->getMessage()]);
            }
        }

        return new JsonResponse(["message" => "Collection successfully saved."]);
    }
    public function update(CreateOrUpdateCollectionRequest $request, CollectionBreakdown $collectionBreakdown)
    {
        $data = $request->validated();
        try {
            $collectionBreakdown->update($data);
            foreach ($data["account_officer_collections"] as $aco) {

                if (isset($aco['collection_ao_id'])) {
                    AccountOfficerCollection::find($aco["collection_ao_id"])->update([
                        "representative" => $aco["representative"],
                        "note" => $aco["note"],
                        "total" => $aco["total"],
                        "grp" => $aco["grp"],
                        "collection_id" => $aco["collection_id"],

                    ]);
                } else {
                    AccountOfficerCollection::create([
                        "representative" => $aco["representative"],
                        "collection_id" => $collectionBreakdown->collection_id,
                        "grp" => CollectionBreakdown::COLLECTION_GRP_ACCOUNT_OFFICER,
                        "note" => $aco["note"],
                        "total" => $aco["total"],
                    ]);
                }
            }
            foreach ($data["branch_collections"] as $bc) {
                if ($bc) {
                    if (isset($bc["id"])) {
                        BranchCollection::find($bc["id"])->update([
                            "total_amount" => $bc["total_amount"],
                            "branch_id" => $bc["branch"]["branch_id"],

                        ]);
                    } else {
                        BranchCollection::create([
                            "collection_id" => $collectionBreakdown->collection_id,
                            "total_amount" => $bc["total_amount"],
                            "branch_id" => $bc["branch"]["branch_id"],
                        ]);
                    }
                }
            }
            if (isset($data["other_payment"])) {
                $op = $data["other_payment"];
                if (isset($op['id'])) {
                    OtherPayment::find($op["id"])->update([
                        "cash_amount" => $op["cash_amount"],
                        "check_amount" => $op["check_amount"],
                        "memo_amount" => $op["memo_amount"],
                        "pos_amount" => $op["pos_amount"],
                        "interbranch_amount" => $op["interbranch_amount"],
                        "collection_id" => $collectionBreakdown->collection_id,
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
    public function deleteAccountOffficerCollection(AccountOfficerCollection $accountOfficerCollection)
    {
        try {
            $accountOfficerCollection->delete();
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
        }
        return response()->json(['message' => 'Successfully removed.']);
    }
    public function deleteBranchCollection(BranchCollection $branchCollection)
    {
        try {
            $branchCollection->delete();
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
        }
        return response()->json(['message' => 'Successfully removed.']);
    }
    public function destroy(CollectionBreakdown $collectionBreakdown)
    {
        try {
            $collectionBreakdown->branch_collections()->delete();
            $collectionBreakdown->pos_collections()->delete();
            $collectionBreakdown->other_payment()->delete();
            $collectionBreakdown->account_officer_collections()->delete();
            $collectionBreakdown->delete();
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
        }

        return response()->json(['message' => 'Deleted successfully.']);
    }
}
