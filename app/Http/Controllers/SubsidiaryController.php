<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\PrepaidExpense;
use App\Models\Subsidiary;
use App\Models\SubsidiaryCategory;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SubsidiaryController extends Controller
{

    public function store(Request $request)
    {
        Log::info('Incoming subsidiary data:', $request->all());

        if (!$request->has('sub_no_depre') || $request->sub_no_depre === null || $request->sub_no_depre === '') {
            $request->merge(['sub_no_depre' => 1]);
        }

        if (Subsidiary::where('sub_code', $request->sub_code)->exists()) {
            return response()->json([
                'message' => 'The subsidiary code already exists. Please choose a different code.',
                'errors' => [
                    'sub_code' => ['The subsidiary code already exists.']
                ]
            ], 422); // 422 Unprocessable Entity
        }

        $monthlyDue = $request['sub_no_depre'] != 0 ? ($request['sub_amount'] - ($request['sub_amount'] * ($request['sub_salvage'] / 100))) / $request['sub_no_depre'] : 0.00;

        $request->merge([
            'monthly_due' => $monthlyDue
        ]);
        $data = $request->validate([
            'sub_code' => 'string|required',
            'sub_name' => 'string|required',
            'sub_address' => 'nullable',
            'sub_tel' => 'nullable',
            'sub_no_amort' => 'sometimes',
            'sub_date' => 'date|sometimes',
            'sub_cat_id' => 'integer|required',
            'sub_salvage' => 'numeric|sometimes',
            'sub_amount' => 'nullable|numeric|sometimes|gt:0',
            'sub_no_depre' => 'numeric|sometimes',
            'sub_per_branch' => 'nullable',
            'branch_id' => 'nullable',
            'branch' => 'nullable',
            'monthly_due' => 'sometimes|numeric',
            'prepaid_expense' => 'required_if:sub_cat_id,0|numeric',
        ], ['required_if' => 'Expense is required.']);

        try {
            if (isset($data['branch']) && isset($data['branch']['branch_id'])) {
                $data['sub_per_branch'] = Branch::where('branch_id', $data['branch']['branch_id'])->pluck('branch_code')->first();
            }
            $subsidiary = Subsidiary::create($data);
            if (isset($data['prepaid_expense'])) {
                $subsidiary->prepaid_expense()->create([
                    'amount' => $data['prepaid_expense'],
                    'sub_id' => $subsidiary->sub_id
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ]);
        }
        $subsidiary =  $subsidiary->with(['subsidiary_category', 'prepaid_expense' => function ($query) {
            return $query->pluck('amount');
        }, 'subsidiary_accounts'])->find($subsidiary->sub_id);

        $branch = null;
        if (!empty($data['branch']['branch_id'])) {
            $branch = Branch::find($data['branch']['branch_id']);
            $branchAlias = $branch->branch_code . '-' . $branch->branch_name;
            $subsidiary->branch = $branchAlias;
        }
        if ($subsidiary->sub_no_depre == 0) {
            $subsidiary->sub_no_depre = 1;
        }

        if ($branch) {
            $subsidiary['branch_code'] = $branch->branch_code;
        } else {
            $subsidiary['branch_code'] = null; // or some default value if needed
        }

        $subsidiary['monthly_amort'] = $subsidiary->monthly_amort;
        $subsidiary['rem'] = $subsidiary->rem;
        $subsidiary['salvage'] = $subsidiary->salvage;
        $subsidiary['description'] = $subsidiary->description;
        $subsidiary['expensed'] = $subsidiary->expensed;
        $subsidiary['unexpensed'] = $subsidiary->unexpensed;
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

    public function show(Subsidiary $subsidiary)
    {
        /*         $branch = Branch::where('branch_code', $subsidiary->sub_per_branch)->first();
        if ($branch) {
            $subsidiary['sub_per_branch'] = $branch->branch_name;
        } */
        return new JsonResponse([
            'data' => $subsidiary,
            'message' => "Successfully fetched."
        ], JsonResponse::HTTP_OK);
    }

    public function update(Subsidiary $subsidiary, Request $request)
    {
        if (Subsidiary::where('sub_code', $request->sub_code)
            ->where('sub_id', '!=', $subsidiary->sub_id)
            ->exists()
        ) {
            return response()->json([
                'message' => 'The subsidiary code already exists. Please choose a different code.',
                'errors' => [
                    'sub_code' => ['The subsidiary code already exists.']
                ]
            ], 422);
        }

        $data = $request->validate([
            'sub_code' => 'string|required',
            'sub_name' => 'string|required',
            'sub_address' => 'nullable',
            'sub_tel' => 'nullable',
            'sub_no_amort' => 'sometimes',
            'sub_date' => 'date|nullable',
            'sub_cat_id' => 'integer|required',
            'sub_salvage' => 'numeric|nullable',
            'sub_amount' => 'numeric|nullable|gt:0',
            'sub_no_depre' => 'numeric|nullable',
            'sub_per_branch' => 'string|nullable',
            'prepaid_expense' => 'required_if:sub_cat_id,0',
            'prepaid_expense_payment' => 'required_if:sub_cat_id,0',
            'monthly_due' => 'sometimes|numeric',
            'new_life' => 'nullable|numeric|min:0'

        ], [
            'required_if' => 'Expense is required.'
        ]);

        $used = (int) $subsidiary->sub_no_amort;
        $newLife = (int) $request->input('new_life', 0);
        $lifeToUse = $newLife > 0 ? $newLife : (int) $subsidiary->sub_no_depre;
        $amount = (float) $request->input('sub_amount', $subsidiary->sub_amount);
        
        // Get rates - handle empty strings as 0
        $oldRate = (float) ($subsidiary->sub_salvage ?? 0) ?: 0;
        $newRate = (float) ($request->input('sub_salvage') ?? 0) ?: 0;
        
        $monthlyDue = 0;
        $unexpensed = 0;
        
        if ($used === 0) {
            // NEW ITEM: Standard calculation
            $salvageValue = ($newRate / 100) * $amount;
            $depreciableAmount = $amount - $salvageValue;
            $monthlyDue = $depreciableAmount / $lifeToUse;
            $unexpensed = $depreciableAmount;
            
        } else {
            // USED ITEM: Complex calculation based on your requirements
            
            if ($oldRate == 0 && $newRate > 0) {
                // Case: No prior rate → New rate (only subtract from unexpensed)
                $originalMonthlyBase = $amount / $lifeToUse;
                $expensed = $used * $originalMonthlyBase;
                $remainingAmount = $amount - $expensed;
                $newSalvageOnRemaining = ($newRate / 100) * $remainingAmount;
                $unexpensed = $remainingAmount - $newSalvageOnRemaining;
                
            } else if ($oldRate > 0 && $newRate != $oldRate) {
                // Case: Existing rate → Different rate (including going to 0)
                $originalSalvage = ($oldRate / 100) * $amount;
                $newSalvage = ($newRate / 100) * $amount;
                $originalDepreciableAmount = $amount - $originalSalvage;
                
                // Expensed based on original calculation
                $expensed = $used * ($originalDepreciableAmount / $lifeToUse);
                $remainingAmount = $amount - $expensed;
                
                if ($newRate == 0) {
                    // Rate cleared: no salvage on remaining amount
                    $unexpensed = $remainingAmount;
                } else {
                    // Rate changed: apply new rate to remaining amount
                    $unexpensed = $remainingAmount - ($newRate / 100) * $remainingAmount;
                }
                
            } else {
                // Case: Same rate or life change only
                if ($newLife > 0 && $newLife != $subsidiary->sub_no_depre) {
                    // Life changed: use current expensed and unexpensed values
                    $expensed = $subsidiary->expensed;
                    $unexpensed = $subsidiary->unexpensed;
                } else {
                    // No changes: recalculate normally
                    $salvageValue = ($newRate / 100) * $amount;
                    $depreciableAmount = $amount - $salvageValue;
                    $originalMonthlyDue = $depreciableAmount / $lifeToUse;
                    
                    $expensed = $used * $originalMonthlyDue;
                    $unexpensed = $depreciableAmount - $expensed;
                }
            }
            
            // Calculate monthly due for remaining months
            $monthsRemaining = max($lifeToUse - $used, 1);
            $monthlyDue = $unexpensed / $monthsRemaining;
        }
        
        // Ensure no negative values
        $monthlyDue = max(0, $monthlyDue);
        $unexpensed = max(0, $unexpensed);
        
        $data['monthly_due'] = round($monthlyDue, 2);
        if ($newLife > 0) {
            $data['sub_no_depre'] = $newLife;
        }

        try {
            $subsidiary->update($data);

            if ($request->category) {
                if ($request->category['sub_cat_name'] === SubsidiaryCategory::ADDTIONAL_PREPAID_EXP) {
                    if ($subsidiary->prepaid_expense) {
                        $subsidiary->prepaid_expense->update([
                            'amount' => $data['prepaid_expense']
                        ]);
                        $subsidiary->prepaid_expense->prepaid_expense_payments()->create([
                            'amount' => $data['prepaid_expense_payment'],
                            'status' => 'unposted',
                            'payment_date' => now()
                        ]);
                    } else {

                        PrepaidExpense::create([
                            'amount' => $data['prepaid_expense'],
                            'sub_id' => $subsidiary->sub_id
                        ]);
                    }
                }
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
        $subsidiary['due_amort'] = $subsidiary->due_amort;
        $subsidiary['inv'] = $subsidiary->inv;
        $subsidiary['no'] = $subsidiary->no;
        $subsidiary['sub_cat_name'] = $subsidiary->sub_cat_name;

        $prepaid_expense = 0;
        $prepaid_payments = [];

        if ($subsidiary->prepaid_expense) {
            $prepaid_payments = $subsidiary->prepaid_expense->prepaid_expense_payments;
            if (count($subsidiary->prepaid_expense->prepaid_expense_payments) > 0) {
                foreach ($subsidiary->prepaid_expense->prepaid_expense_payments as $payment) {

                    $prepaid_expense += $payment->amount;
                }
                $subsidiary['prepaid_expense'] = $prepaid_expense;
            }
            $upostedPaymentsTotal = $prepaid_payments->where('status', 'unposted')->sum('amount');
        } else {
            $subsidiary['prepaid_expense'] = 0;
        }


        $subsidiary['unposted_payments'] = $subsidiary->prepaid_expense ? $upostedPaymentsTotal : 0;
        $prepaidUnexpensed = $subsidiary->sub_amount - $prepaid_expense;
        
        if (
            optional($request->category)['sub_cat_name'] === SubsidiaryCategory::ADDTIONAL_PREPAID_EXP &&
            optional($subsidiary->prepaid_expense)->amount > 0
        ) {
            $subsidiary['unexpensed'] = $prepaidUnexpensed;
        } else {
            $subsidiary['unexpensed'] = $subsidiary->unexpensed;
        }

        \Log::info('Original Attributes', $subsidiary->getAttributes());
        \Log::info('Merged Attributes with due_amort', array_merge(
            $subsidiary->getAttributes(),
            ['due_amort' => $monthlyDue]
        ));

        return response()->json([
            'message' => 'Successfully updated.',
            'data' => array_merge(
                $subsidiary->getAttributes(),
                ['due_amort' => $monthlyDue]
            ),
        ], 200);
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
