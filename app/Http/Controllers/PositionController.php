<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePositionRequest;
use App\Models\Position;
use Illuminate\Auth\Events\Validated;
use Illuminate\Contracts\Support\ValidatedData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PositionController extends Controller
{
    public function addPosition( StorePositionRequest $request){
        $user = Auth::user();
        $validatedData = $request->validated();
        $validatedData['user_id'] = $user->id;
        $position = Position::create($validatedData);
        return response()->json([
            'message' => 'Position created successfully',
            'position' => $position
        ], 201);

    }
     public function updatePosition( StorePositionRequest $request,$position_id){
        $user = Auth::user();
        $position = Position::findOrFail($position_id);
        if ($position->user_id !== $user->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        $validatedData = $request->validated();
        $position->update($validatedData);
        return response()->json([
            'message' => 'Position updated successfully',
            'position' => $position
        ], 201);

    }
}
