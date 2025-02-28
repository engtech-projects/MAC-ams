<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Subsidiary;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SubsidiaryController extends Controller
{

    public function store(Request $request)
    {
        $data = $request->validate([
            'sub_name' => 'string|required',
            'sub_no_amort' => 'required',
            'sub_date' => 'date|required',
            'sub_cat_id' => 'integer|required',
            'sub_salvage' => 'numeric|required',
            'sub_amount' => 'numeric|required',
            'sub_no_depre' => 'numeric|required',
            'sub_per_branch' => 'nullable',
            'branch_id' => 'nullable',

        ]);

        try {
            if ($data['branch_id']) {
                $data['sub_per_branch'] = Branch::where('branch_id', $data['branch_id'])->pluck('branch_code')->first();
            }
            Subsidiary::create($data);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ]);
        }
        return new JsonResponse([
            'message' => 'Successfully created.'
        ], JsonResponse::HTTP_CREATED);
    }

    public function update(Subsidiary $subsidiary, Request $request)
    {
        $data = $request->validate([
            'sub_name' => 'string|required',
            'sub_no_amort' => 'required',
            'sub_date' => 'date|required',
            'sub_cat_id' => 'integer|required',
            'sub_salvage' => 'numeric|required',
            'sub_amount' => 'numeric|required',
            'sub_no_depre' => 'numeric|required',
            'sub_per_branch' => 'string',

        ]);
        try {
            $subsidiary->update($data);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ]);
        }

        return response()->json(['message' => 'Successfully updated.', 'data' => $subsidiary], 200);
    }

    public function destroy(Subsidiary $subsidiary)
    {
        try {
            $subsidiary->delete();
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ]);
        }

        return response()->json(['message' => 'Successfully deleted.'], 200);
    }
}
