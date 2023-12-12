<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use Illuminate\Http\Request;

class BranchController extends Controller
{

    public function index() {
        $branch = new Branch();
        return response()->json(['data' => $branch->fetchBranch()]);
    }

}
