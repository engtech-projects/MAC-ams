<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends MainController
{

    public function index() {

    	$title = 'Dashboard'.' - '.config('app.name');

    	return view('dashboard.dashboard')->with(compact('title'));
    }
}
