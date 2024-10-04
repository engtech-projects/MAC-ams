<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Subsidiary;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SubsidiaryController extends Controller
{

    public function create(Request $request)
    {
        try {
            Subsidiary::create($request->input());
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
