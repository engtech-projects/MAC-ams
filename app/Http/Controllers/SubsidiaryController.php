<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\PrepaidExpense;
use App\Models\Subsidiary;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SubsidiaryController extends Controller
{

    public function store(Request $request)
    {
        Log::info('Incoming subsidiary data:', $request->all());


        $data = $request->validate([
            'sub_code' => 'string|required',
            'sub_name' => 'string|required',
            'sub_no_amort' => 'required',
            'sub_date' => 'date|required',
            'sub_cat_id' => 'integer|required',
            'sub_salvage' => 'numeric|required',
            'sub_amount' => 'numeric|required',
            'sub_no_depre' => 'numeric|required',
            'sub_per_branch' => 'nullable',
            'branch_id' => 'nullable',
            'branch' => 'nullable',
            'prepaid_expense' => 'required_if:sub_cat_id,0',
        ], [
            'required_if' => 'Expense is required.'
        ]);

        try {
            if ($data['branch']) {
                $data['sub_per_branch'] = Branch::where('branch_id', $data['branch']['branch_id'])->pluck('branch_code')->first();
            }
            $subsidiary = Subsidiary::create($data);

            $subsidiary->prepaid_expense()->create([
                'amount' => $data['prepaid_expense'],
                'sub_id' => $subsidiary->sub_id
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ]);
        }
        $subsidiary =  $subsidiary->with(['subsidiary_category', 'prepaid_expense' => function ($query) {
            return $query->pluck('amount');
        }, 'subsidiary_accounts'])->find($subsidiary->sub_id);

        $branch = Branch::find($data['branch']['branch_id']);
        $branchAlias = $branch->branch_code . '-' . $branch->branch_name;
        $subsidiary->branch = $branchAlias;
        if ($subsidiary->sub_no_depre == 0) {
            $subsidiary->sub_no_depre = 1;
        }

        $subsidiary['branch_code'] = $branch->branch_code;

        $subsidiary['monthly_amort'] = $subsidiary->monthly_amort;
        $subsidiary['rem'] = $subsidiary->rem;
        $subsidiary['salvage'] = $subsidiary->salvage;
        $subsidiary['description'] = $subsidiary->description;
        $subsidiary['expensed'] = $subsidiary->expensed;
        $subsidiary['unexpensed'] = $subsidiary->prepaid_expense ? $subsidiary->sub_amount - $subsidiary->prepaid_expense->amount : $subsidiary->unexpensed;
        $subsidiary['due_amort'] = $subsidiary->due_amort;
        $subsidiary['inv'] = $subsidiary->inv;
        $subsidiary['no'] = $subsidiary->no;
        $subsidiary['sub_cat_name'] = $subsidiary->sub_cat_name;
        $subsidiary->prepaid_expense = $subsidiary->prepaid_expense ? $subsidiary->prepaid_expense->amount : 0;
        return new JsonResponse([
            'data' => $subsidiary->getAttributes(),
            'message' => 'Successfully created.'
        ], JsonResponse::HTTP_CREATED);
    }

    public function update(Subsidiary $subsidiary, Request $request)
    {
        $data = $request->validate([
            'sub_code' => 'string|required',
            'sub_name' => 'string|required',
            'sub_no_amort' => 'required',
            'sub_date' => 'date|required',
            'sub_cat_id' => 'integer|required',
            'sub_salvage' => 'numeric|required',
            'sub_amount' => 'numeric|required',
            'sub_no_depre' => 'numeric|required',
            'sub_per_branch' => 'string',
            'prepaid_expense' => 'required_if:sub_cat_id,0',

        ], [
            'required_if' => 'Expense is required.'
        ]);
        try {
            $subsidiary->update($data);
            if ($subsidiary->prepaid_expense) {
                $subsidiary->prepaid_expense->update([
                    'amount' => $data['prepaid_expense']
                ]);
            } else {

                PrepaidExpense::create([
                    'amount' => $data['prepaid_expense'],
                    'sub_id' => $subsidiary->sub_id
                ]);
            }
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ]);
        }
        $subsidiary['branch'] = $subsidiary->branch;
        $subsidiary['monthly_amort'] = $subsidiary->monthly_amort;
        $subsidiary['rem'] = $subsidiary->rem;
        $subsidiary['salvage'] = $subsidiary->salvage;
        $subsidiary['description'] = $subsidiary->description;
        $subsidiary['expensed'] = $subsidiary->expensed;
        $subsidiary['unexpensed'] = $subsidiary->prepaid_expense ? $subsidiary->sub_amount - $subsidiary->prepaid_expense->amount : $subsidiary->unexpensed;
        $subsidiary['due_amort'] = $subsidiary->due_amort;
        $subsidiary['inv'] = $subsidiary->inv;
        $subsidiary['no'] = $subsidiary->no;
        $subsidiary['sub_cat_name'] = $subsidiary->sub_cat_name;
        $subsidiary['prepaid_expense'] = $subsidiary->prepaid_expense ? $subsidiary->prepaid_expense->amount : 0;

        return response()->json(['message' => 'Successfully updated.', 'data' => $subsidiary->getAttributes()], 200);
    }

    public function destroy(Subsidiary $subsidiary)
    {
        try {
            $subsidiary->subsidiary_accounts()->detach([$subsidiary->sub_id]);
            $subsidiary->subsidiary_opening_balance()->delete($subsidiary->sub_id);
            $subsidiary->prepaid_expense()->delete($subsidiary->sub_id);
            $subsidiary->delete($subsidiary);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ]);
        }

        return response()->json(['message' => 'Successfully deleted.'], 200);
    }
}