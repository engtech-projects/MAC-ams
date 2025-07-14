<?php

namespace App\Http\Controllers;

use App\Models\Subsidiary;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class DashboardController extends MainController
{

    public function index()
    {


        $title = 'MAC-AMS | Dashboard';



        /* return new JsonResource([
            'data' => $title,
            'message' => 'Successfully Fetched.'
        ], JsonResponse::HTTP_OK); */
        return view('dashboard.dashboard')->with(compact('title'));
    }
}