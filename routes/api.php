<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\ReportsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::get('reports/general-ledger-search', [ReportsController::class, 'generalLedgerSearch'])->name('reports.generalLedgerSearch');
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
/* Route::post('authenticate', [LoginController::class, 'authenticate'])->name('login.user');



Route::get('user',[LoginController::class,'user'])->name('logged.user'); */