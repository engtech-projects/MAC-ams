<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateOrUpdateCollectionRequest;
use App\Models\CollectionBreakdown;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class CollectionController extends Controller
{

    public function store(CreateOrUpdateCollectionRequest $request)
    {
        $collection = new CollectionBreakdown();
        try {
            $collection->createCollection($request->validated());
        } catch (\Exception $exception) {
            return new JsonResponse(["message" => $exception->getMessage()]);
        }
        return new JsonResponse(["message" => "Collection successfully saved."]);
    }

    public function destroy(CollectionBreakdown $collection)
    {
        $collection->delete();
        return response()->json(["message"=> "Collection successfully deleted.","data" => $collection]);
    }

}
