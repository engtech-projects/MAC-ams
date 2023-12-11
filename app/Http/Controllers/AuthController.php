<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller {

    public function __construct() {
        $this->middleware("auth");
    }
    public function getAuthUser()
    {
        return auth()->user();
    }
}
