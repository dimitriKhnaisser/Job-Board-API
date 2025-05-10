<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreApplicationRequest;
use App\Http\Resources\ApplicationResource;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $user_id = Auth::user()->id;
        $validatedData = $request->validated();
        $validatedData['user_id'] = $user_id;
        $validatedData['job_id'] = $job_id;
        if($request->hasFile('resume')){
            $path = $request->file('resume')->store('my resume','public');
            $validatedData['resume'] = $path;
        }
        $application = Application::create($validatedData);
        return new ApplicationResource($application);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
        //
    }
}
