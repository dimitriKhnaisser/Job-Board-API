<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreApplicationRequest;
use App\Http\Resources\ApplicationResource;
use App\Models\Application;
use App\Models\Job;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Ramsey\Uuid\Type\Integer;

class ApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $allApplications=Application::all();
        return response()->json($allApplications);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreApplicationRequest $request,$job_id)
    {
       try{
           
            $job = Job::where('id', $job_id)->first();
            if (!$job) {
                return response()->json([
                    'message' => 'Job not found'
                ], 404);
            }
            if (!$job->open) {
                return response()->json([
                    'message' => 'Job is not open for applications'
                ], 400);
            }
            $user_id = Auth::user()->id;
            $validatedData = $request->validated();
            $validatedData['user_id'] = $user_id;
            $validatedData['job_id'] = $job_id;
            $applicationExists=Application::where('user_id',$user_id)->where('job_id',$job_id)->exists();
            if($applicationExists)
                 return response()->json([
                    'message'=>'User have already applied'
                 ],409);
            if($request->hasFile('resume')){
                $path = $request->file('resume')->store('resume','public');
                $validatedData['resume'] = $path;
            }
            $application = Application::create($validatedData);
            return new ApplicationResource($application);
   
        }
        catch (QueryException $e) {
            return response()->json([
                'message' => 'An error occurred while processing your application.'
                ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
   public function showJobApplications($job_id)
{
    $company = Auth::user();

    // Check if job exists and belongs to the authenticated company
    $job = Job::where('id', $job_id)
              ->where('company_id', $company->id)
              ->first();

    if (!$job) {
        return response()->json([
            'message' => 'Job not found or does not belong to your company'
        ], 404);
    }

    $allApplications = $job->applications;

    if ($allApplications->isEmpty()) {
        return response()->json([
            'message' => 'No applications found for this job'
        ], 404);
    }

    return response()->json($allApplications);
}


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //can not update application
        return response()->json([
            'message' => 'Application cannot be updated'
        ], 403);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //can not delete application
        return response()->json([
            'message' => 'Application cannot be deleted'
        ], 403);
    }
}
