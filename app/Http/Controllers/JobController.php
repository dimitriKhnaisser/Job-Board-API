<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreJobRequest;
use App\Http\Requests\UpdateJobRequest;
use App\Models\Company;
use App\Models\Job;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Ramsey\Uuid\Type\Integer;

class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch all jobs from the database
        $jobs = Job::all();
        // Return the jobs as a JSON response
        return response()->json($jobs);
    }

    public function companyJobs($company_id)
    {
        $jobs = Job::where('company_id', $company_id)->get();
        return response()->json($jobs);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreJobRequest $request)     
    {
        $company_id = $request->user()->id; 
        $validatedData = $request->validated();
        $validatedData['company_id'] = $company_id;
        // Create a new job using the validated data
        $job = Job::create($validatedData);
        return response()->json([
            'message' => 'Job created successfully',
            'job' => $job
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Find the job by ID
        try {
            $job = Job::findOrFail($id);
            return response()->json($job);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Job not found',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateJobRequest $request,$company_id,$job_id)
    {
        // Find the job by ID
        try{
        $job = Company::findOrFail($company_id)->jobs()->findOrFail($job_id);
        // Update the job with the validated data
        $job->update($request->validated());

        return response()->json([
            'message' => 'Job updated successfully',
            'job' => $job
        ]);
    }catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Job not found',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
   
    public function toggleOpen($job_id){
        try{
            $company_id = Auth::user()->id;
            $job = Job::findOrFail($job_id)->where('company_id', $company_id)->firstOrFail();
            $openStatus = $job->open;
            if($openStatus){
                $job->update(['open' => false]);
                return response()->json([
                    'message' => 'Job closed successfully',
                    'job' => $job
                ]);
            }
            $job->update(['open' => true]);
            return response()->json([
                'message' => 'Job opened successfully',
                'job' => $job
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Job not found',
                'error' => $e->getMessage()
            ], 404);
        }
    }
    public function destroy(string $job_id)
    {
        $company_id = auth()->user()->id;
        $job = Job::where('id', $job_id)->where('company_id', $company_id)->first();

        if (!$job) {
            return response()->json(['message' => 'Job not found or unauthorized'], 404);
        }

        $job->delete();

        return response()->json([
            'message' => 'Job deleted successfully'
        ], 200);
    }
}


