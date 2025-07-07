<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\SubsidiaryCategoryRequest;
use App\Models\Subsidiary;
use App\Models\SubsidiaryCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

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
            $categoryAccounts = [
                $data['account_id_credit'] => ['transaction_type' => 'credit'],
                $data['account_id_debit'] => ['transaction_type' => 'debit'],
            ];
            $category->accounts()->attach($categoryAccounts);
            /*   activity()
                ->performedOn($category)
                ->log('created');
            $lastActivity = Activity::all()->last(); //returns the last logged activity

            $lastActivity->subject; //returns the model that was passed to `performedOn`;
            dd($lastActivity); */
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
