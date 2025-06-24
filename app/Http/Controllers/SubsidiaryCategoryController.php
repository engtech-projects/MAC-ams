<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\SubsidiaryCategoryRequest;
use App\Models\Subsidiary;
use App\Models\SubsidiaryCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SubsidiaryCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SubsidiaryCategoryRequest $request)
    {
        $data = $request->validated();
        try {
            $category = SubsidiaryCategory::create($data);
            $category->accounts()->attach([
                $data['account_id_credit'],
                $data['account_id_debit']
            ]);
        } catch (\Throwable $th) {
            return new JsonResponse([
                'message' => $th->getMessage()
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
        return new JsonResponse([
            'message' => "Successfully created."
        ], JsonResponse::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
