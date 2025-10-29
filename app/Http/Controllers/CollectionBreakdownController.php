<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateOrUpdateCollectionRequest;
use App\Models\AccountOfficerCollection;
use App\Models\BranchCollection;
use App\Models\PosCollection;
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
        }
        try {
            DB::transaction(function () use ($attributes, $collection_ao) {
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
                $collection->load(['other_payment', 'account_officer_collections', 'branch_collections', 'pos_collections']);
                activity("Cashier's Transaction Blotter")->event('created')->performedOn($collection)
                        ->withProperties([
                            'model_snapshot' => $collection->toArray()
                        ])
                        ->log("Collection Breakdown - Create");
            });
        } catch (\Exception $exception) {
            return new JsonResponse(["message" => $exception->getMessage()], 500);
        }

        return new JsonResponse(["message" => "Collection successfully saved."]);
    }
    public function update(CreateOrUpdateCollectionRequest $request, CollectionBreakdown $collectionBreakdown)
    {
        $data = $request->validated();
        $collectionBreakdown->load(['other_payment', 'account_officer_collections', 'branch_collections', 'pos_collections']);
        $replicate = $collectionBreakdown->replicate();
        $oldRelationships = [
            'other_payment' => $collectionBreakdown->other_payment ? $collectionBreakdown->other_payment->toArray() : null,
            'account_officer_collections' => $collectionBreakdown->account_officer_collections->toArray(),
            'branch_collections' => $collectionBreakdown->branch_collections->toArray(),
            'pos_collections' => $collectionBreakdown->pos_collections->toArray(),
        ];
        try {
            DB::transaction(function () use ($collectionBreakdown, $data, $replicate, $oldRelationships) {
                $this->handleCollectionDeletions($collectionBreakdown, $data);
                $collectionBreakdown->update($data);
                $this->processAccountOfficerCollections($collectionBreakdown, $data);
                $this->processBranchCollections($collectionBreakdown, $data);
                $this->processPosCollections($collectionBreakdown, $data);
                $this->processOtherPayments($collectionBreakdown, $data);
                $collectionBreakdown->refresh();
                $collectionBreakdown->load(['other_payment', 'account_officer_collections', 'branch_collections', 'pos_collections']);
                $newRelationships = [
                    'other_payment' => $collectionBreakdown->other_payment ? $collectionBreakdown->other_payment->toArray() : null,
                    'account_officer_collections' => $collectionBreakdown->account_officer_collections->toArray(),
                    'branch_collections' => $collectionBreakdown->branch_collections->toArray(),
                    'pos_collections' => $collectionBreakdown->pos_collections->toArray(),
                ];
                $changes = getChanges($collectionBreakdown, $replicate);
                unset($changes['attributes']['updated_at'], $changes['old']['updated_at']);
                $relationshipsChanged = false;
                $relationshipChanges = [
                    'old' => [],
                    'attributes' => []
                ];
                foreach ($oldRelationships as $key => $oldValue) {
                    $newValue = $newRelationships[$key];
                    if (json_encode($oldValue) !== json_encode($newValue)) {
                        $relationshipsChanged = true;
                        $relationshipChanges['old'][$key] = $oldValue;
                        $relationshipChanges['attributes'][$key] = $newValue;
                    }
                }
                if ($relationshipsChanged) {
                    $changes['old'] = array_merge($changes['old'], $relationshipChanges['old']);
                    $changes['attributes'] = array_merge($changes['attributes'], $relationshipChanges['attributes']);
                }
                if (!empty($changes['attributes']) || $relationshipsChanged) {
                    activity("Cashier's Transaction Blotter")
                        ->event('updated')
                        ->performedOn($collectionBreakdown)
                        ->withProperties([
                            'model_snapshot' => $collectionBreakdown->toArray(),
                            'attributes' => $changes['attributes'],
                            'old' => $changes['old']
                        ])
                        ->log("Collection Breakdown - Update");
                }
            });
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
        return response()->json(['message' => 'Successfully updated.']);
    }

    protected function handleCollectionDeletions($collectionBreakdown, $data)
    {
        $incomingAoIds = isset($data['account_officer_collections'])
            ? collect($data['account_officer_collections'])->pluck('collection_ao_id')->filter()->toArray()
            : [];
        $existingAoIds = $collectionBreakdown->account_officer_collections()->pluck('collection_ao_id')->toArray();
        $toDeleteAoIds = array_diff($existingAoIds, $incomingAoIds);
        if (!empty($toDeleteAoIds)) {
            AccountOfficerCollection::whereIn('collection_ao_id', $toDeleteAoIds)->delete();
        }
        $incomingBranchIds = isset($data['branch_collections'])
            ? collect($data['branch_collections'])->pluck('id')->filter()->toArray()
            : [];
        $existingBranchIds = $collectionBreakdown->branch_collections->pluck('id')->toArray();
        $toDeleteBranchIds = array_diff($existingBranchIds, $incomingBranchIds);
        if (!empty($toDeleteBranchIds)) {
            BranchCollection::destroy($toDeleteBranchIds);
        }
        $incomingPosIds = isset($data['pos_collections'])
            ? collect($data['pos_collections'])->pluck('id')->filter()->toArray()
            : [];
        $existingPosIds = $collectionBreakdown->pos_collections->pluck('id')->toArray();
        $toDeletePosIds = array_diff($existingPosIds, $incomingPosIds);
        if (!empty($toDeletePosIds)) {
            PosCollection::destroy($toDeletePosIds);
        }
    }

    protected function processAccountOfficerCollections($collectionBreakdown, $data)
    {
        if (!isset($data["account_officer_collections"])) return;

        foreach ($data["account_officer_collections"] as $aco) {
            if (!empty($aco['collection_ao_id'])) {
                AccountOfficerCollection::where('collection_ao_id', $aco['collection_ao_id'])
                    ->update([
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
    }

    protected function processBranchCollections($collectionBreakdown, $data)
    {
        if (!isset($data["branch_collections"])) return;

        foreach ($data["branch_collections"] as $bc) {
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

    protected function processPosCollections($collectionBreakdown, $data)
    {
        if (!isset($data["pos_collections"])) return;

        foreach ($data["pos_collections"] as $pc) {
            if (isset($pc['id'])) {
                PosCollection::find($pc['id'])->update([
                    "total_amount" => $pc["total_amount"],
                    "or_no" => $pc["or_no"],
                ]);
            } else {
                $collectionBreakdown->pos_collections()->create([
                    "total_amount" => $pc["total_amount"],
                    "or_no" => $pc["or_no"],
                ]);
            }
        }
    }

    protected function processOtherPayments($collectionBreakdown, $data)
    {
        if (!isset($data["other_payment"])) return;

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
            $collectionBreakdown->load(['other_payment', 'account_officer_collections', 'branch_collections', 'pos_collections']);
            $snapshot = $collectionBreakdown->toArray();
            DB::transaction(function () use ($collectionBreakdown, $snapshot) {
                $collectionBreakdown->branch_collections()->delete();
                $collectionBreakdown->pos_collections()->delete();
                $collectionBreakdown->other_payment()->delete();
                $collectionBreakdown->account_officer_collections()->delete();
                $collectionBreakdown->delete();

                activity("Cashier's Transaction Blotter")->event('deleted')->performedOn($collectionBreakdown)
                    ->withProperties([
                        'model_snapshot' => $snapshot,
                        'old' => $snapshot
                    ])
                    ->log("Collection Breakdown - Delete");
            });
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }

        return response()->json(['message' => 'Deleted successfully.']);
    }
}
