<?php

use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\UserController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::apiResource('users',UserController::class);
Route::post('user/login',[UserController::class,'login']);

Route::middleware('auth:sanctum')->group(function(){

Route::post('user/logout',[UserController::class,'logout']);
Route::get('user/applications',[UserController::class,'getApplications']);
Route::get('user/industry',[UserController::class,'getIndustry']);
Route::get('user/job',[UserController::class,'getJob']);
Route::get('user/role',[UserController::class,'getRole']);

Route::post('application/{jobId}/job',[ApplicationController::class,'store']);


} );
