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
            $user_id = Auth::user()->id;
            $validatedData = $request->validated();
            $validatedData['user_id'] = $user_id;
            $validatedData['job_id'] = $job_id;
            $applicationExists=Application::where('user_id',$user_id)->where('job_id',$job_id)->exists();
            if($applicationExists)
                 return response()->json([
                    'message'=>'User have already applied'
                 ]);
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
        $allApplications = Job::find($job_id)->applications;  
        return response()->json($allApplications);     
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        
    }
}
