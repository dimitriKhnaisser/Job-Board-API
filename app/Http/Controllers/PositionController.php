<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePositionRequest;
use App\Http\Requests\UpdatePositionRequest;
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
     public function updatePosition( UpdatePositionRequest $request,$position_id){
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
        ], 200);

    }
    public function deletePosition($position_id){
        $user = Auth::user();
        $position = Position::findOrFail($position_id);
        if ($position->user_id !== $user->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        $position->delete();
        return response()->json([
            'message' => 'Position deleted successfully'
        ], 200);
    }
}
