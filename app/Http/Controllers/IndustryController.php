<?php

namespace App\Http\Controllers;

use App\Models\Industry;
use Exception;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IndustryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $industries  = Industry::all();
        return response()->json([
            'message' => 'Industries retrieved successfully',
            'industries' => $industries
        ], 200);
    }
    public function indexSearch(Request $request)
    {
        $industryName = Industry::where('name', 'like', '%' . $request->input('name') . '%')->get();
        if ($industryName->isEmpty()) {
            return response()->json([
                'message' => 'No industries found with that name'
            ], 404);
        }
        return response()->json([
            'message' => 'Industries retrieved successfully',
            'industries' => $industryName
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{
        $industry = Industry::create(
            $request->validate([
                'name' => 'required|string|max:255',
            ])
            );
            return response()->json([
                'message' => 'Industry created successfully',
                'industry' => $industry
            ], 201);
        }
        catch(Exception $e){
            return response()->json([
                'message' => 'Industry already exists' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $industry = Industry::findOrFail($id);
        return response()->json([
            'message' => 'Industry retrieved successfully',
            'industry' => $industry
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $industry_id)
    {
        $industry = Industry::findOrFail($industry_id);
        $industry->update(
            $request->validate([
                'name' => 'required|string|max:255',
            ])
        );
        return response()->json([
            'message' => 'Industry updated successfully',
            'industry' => $industry
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $industry_id)
    {
        $industry = Industry::findOrFail($industry_id);
        $industry->delete();
        return response()->json([
            'message' => 'Industry deleted successfully'
        ], 200);
   
    }
    public function companiesIndustry($industry_id)
    {
        $companies = Industry::findOrFail($industry_id)->companies;
        return response()->json([
            'message' => 'Companies in this industry retrieved successfully',
            'companies' => $companies
        ], 200);
    } 
    public function usersIndustry($industry_id)
    {
        $users = Industry::findOrFail($industry_id)->users;
        return response()->json([
            'message' => 'Users in this industry retrieved successfully',
            'users' => $users
        ], 200);
    }
    public function addUserIndustry(Request $request){
        //this function is used to add industry to user
        //at first the user will type the industry name
        //if the industry exists it will be added to user
        //if the industry does not exist it will be created and then added to user
        $user = $request->user();
        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        $industry = Industry::firstOrCreate($request->validate([
            'name'=> 'required|string|max:255',
        ]));
        $user->industry_id = $industry->id;
        $user->save();
        return response()->json([
            'message' => 'User industry updated successfully',
            'user' => $user
        ], 200);
    }
    public function removeUserIndustry(){
        $user = request()->user();
        $user->industry_id = null;
        $user->update('industry_id', null);
        return response()->json([
            'message' => 'User industry removed successfully',
            'user' => $user
        ], 200);

    }
}
