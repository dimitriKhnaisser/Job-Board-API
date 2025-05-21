<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreJobRequest;
use App\Http\Requests\UpdateJobRequest;
use App\Models\Company;
use App\Models\Job;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
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
        // Fetch all jobs for a specific company
        $jobs = Job::where('company_id', $company_id)->get();
        // Return the jobs as a JSON response
        return response()->json($jobs);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreJobRequest $request,$company_id)     
    {
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
    public function destroy(string $id)
    {
        //
    }
}
