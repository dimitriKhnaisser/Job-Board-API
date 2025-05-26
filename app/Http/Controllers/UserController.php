<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\ApplicationResource;
use App\Http\Resources\UserResource;
use App\Models\Job;
use App\Models\User;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $allUsers = User::with(['industry', 'applications'])->get();
        return UserResource::collection($allUsers);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {

        $validatedData = $request->validated();
        $user = User::create([
            'name'=>$validatedData['name'],
            'email'=>$validatedData['email'],
            'password'=> Hash::make($validatedData['password']),
            'industry_id'=>$validatedData['industry_id'],
            
        ]);
        return new UserResource($user);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::findOrFail($id);
        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, string $id)
    {
        $user = User::findOrFail($id);
        $user->update($request->validated());
        return new UserResource($user);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return response()->json("Deleted");
    }
    public function login(Request $request){
        $validateForm = $request->validate([
            'email'=>'required|string|email',
            'password'=>'required|string'
        ]);
        if(!Auth::attempt($request->only('email','password')))
            return response()->json("Wrong email or password");

        $user = User::where('email',$request->email)->firstOrFail();
        $token = $user->createToken('login_token')->plainTextToken;
        return response()->json([
            "message"=>"Login success",
            'user'=>new UserResource($user),
            'token'=>$token
         ]);   
    }
    public function logout(Request $request){
        $user = $request->user();//get the user of the token entered 
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'message'=>"Logout success",
            'user'=>new UserResource($user)
        ]);
    }
    public function getApplications(){
        $user = Auth::user();
        $applications = $user->applications;   
        return ApplicationResource::collection($applications);
    }
    public function getIndustry(){
        $user = Auth::user();
        $industry = $user->industry;
        return response()->json($industry);
   
    }
   
    public function getRole(){
        $user = Auth::user();
        $role = $user->role;
        return response()->json($role);
    }

    public function getPositions(){
        $user = Auth::user();
        $position = $user->positions;
        return response()->json($position);
    }
}
