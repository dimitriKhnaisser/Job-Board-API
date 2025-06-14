<?php

use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\IndustryController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\UserController;
use App\Models\Company;
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
Route::post('company/login',[CompanyController::class,'login']);
Route::post('addCompany',[CompanyController::class,'register']);

Route::middleware('auth:sanctum')->group(function(){
Route::get('user/setIndustry',[IndustryController::class,'addUserIndustry']);
Route::get('allCompanies',[CompanyController::class,'index']);
Route::get('showCompany',[CompanyController::class,'show']);
Route::get('showCompanyByName',[CompanyController::class,'showCompanyByName']);

Route::get('industry/{industry_id}/companies',[IndustryController::class,'companiesIndustry']);
} );

Route::middleware(['auth:sanctum', 'is_user'])->group(function () {
Route::post('user/logout',[UserController::class,'logout']);
Route::get('user/applications',[UserController::class,'getApplications']);
Route::get('user/industry',[UserController::class,'getIndustry']);
Route::get('user/positions',[UserController::class,'getPositions']);
Route::get('user/role',[UserController::class,'getRole']);
Route::post('user/addPosition',[PositionController::class,'addPosition']);
Route::put('user/updatePosition/{position_id}',[PositionController::class,'updatePosition']);
Route::post('job/{jobId}/application',[ApplicationController::class,'store']);

});

Route::middleware(['auth:sanctum', 'is_company'])->group(function () {
Route::get('company/{company_id}/allJobs',[JobController::class,'companyJobs']);
Route::post('company/{company_id}/addJob',[JobController::class,'store']);
Route::put('company/{company_id}/updateJob/{jobId}',[JobController::class,'update']); 
Route::post('company/logout',[CompanyController::class,'logout']);
Route::get('job/{jobId}/allApplications',[ApplicationController::class,'showJobApplications']);
Route::get('updateCompany',[CompanyController::class,'update']);
Route::get('deleteCompany',[CompanyController::class,'delete']);


});

