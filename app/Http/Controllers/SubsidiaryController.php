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
            'sub_amount' => 'nullable|numeric|sometimes',
            'sub_no_depre' => 'numeric|sometimes',
            'sub_per_branch' => 'nullable',
            'branch_id' => 'nullable',
            'branch' => 'nullable',
            'monthly_due' => 'sometimes|numeric',
            'prepaid_expense' => 'required_if:sub_cat_id,0',
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


        $monthlyDue = $subsidiary['sub_no_depre'] != 0 ? ($request['sub_amount'] - ($request['sub_amount'] * ($request['sub_salvage'] / 100))) / $request['sub_no_depre'] : 0.00;
        $request->merge([
            'monthly_due' => $monthlyDue
        ]);

        $data = $request->validate([
            'sub_code' => 'string|required',
            'sub_name' => 'string|required',
            'sub_no_amort' => 'sometimes',
            'sub_date' => 'date|nullable',
            'sub_cat_id' => 'integer|required',
            'sub_salvage' => 'numeric|nullable',
            'sub_amount' => 'numeric|nullable',
            'sub_no_depre' => 'numeric|nullable',
            'sub_per_branch' => 'string|nullable',
            'prepaid_expense' => 'required_if:sub_cat_id,0',
            'prepaid_expense_payment' => 'required_if:sub_cat_id,0',
            'monthly_due' => 'sometimes|numeric',

        ], [
            'required_if' => 'Expense is required.'
        ]);
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
        $prepaidUnexpensed =  $subsidiary->sub_amount - $prepaid_expense;
        $subsidiary['unexpensed'] = $subsidiary->prepaid_expense ? $prepaidUnexpensed : $subsidiary->unexpensed;

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
