<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\BranchController;
use App\Http\Controllers\EmployeeController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(BranchController::class)->group(function () {
    Route::get('/branches', 'index');
    Route::post('/branches', 'store');
    Route::get('/branches/{branch}', 'show');
});

Route::controller(EmployeeController::class)->group(function () {
    Route::post('/branches/{branch}/employees', 'store');
});


