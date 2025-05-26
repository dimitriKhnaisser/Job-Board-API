<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCompanyRequest;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $companies = Company::all();
        return response()->json($companies);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name'=>'required|string|max:255',
            'address'=>'required|string|max:255',
            'email'=>'required|email|max:255|unique:companies,email',
            'password'=>'required|min:8|max:255|confirmed',
            'industry_id'=>'required|exists:industries,id',
        ]);

        $validatedData['password'] = Hash::make($validatedData['password']);
        $company = Company::create($validatedData);

        return response()->json($company, 201);
        
    }

    public function login(Request $request){

        $validatedData = $request->validate([
            'email'=>'required|email|max:255',
            'password'=>'required|min:8|max:255',
        ]);
        $company = Company::where('email',$validatedData['email'])->first();  
        if($company && Hash::check($validatedData['password'], $company->password)){
            $token = $company->createToken('auth_token')->plainTextToken;
            return response()->json(['token'=>$token],200);
       }
       return response()->json(['message'=>'Invalid credentials'],401);
    }

    public function logout(Request $request){
        $company = Auth::user();
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message'=>'Logged out successfully',
        'company'=>$company
    ],200);
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
