<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Subsidiary;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SubsidiaryController extends Controller
{

    public function store(Request $request)
    {
        $data = $request->validate([
            'sub_name' => 'string|required',
            'sub_code' => 'string|required',
            'sub_address' => 'string|required',
            'sub_tel' => 'string',
            'sub_acct_no' => 'string|required',
            'sub_salvage' => 'numeric|required',
            'sub_amount' => 'numeric|required',
            'sub_no_depre' => 'numeric|required',

        ]);
        try {
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
