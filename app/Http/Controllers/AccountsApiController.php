<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Accounts;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AccountsApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $accounts = Accounts::fetch();

        return new JsonResponse([
            'data' => $accounts
        ], JsonResponse::HTTP_OK);
        return view('chartofaccounts.accounts', $data);
    }


    public function store(Request $request)
    {
        //
    }


    public function show($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
