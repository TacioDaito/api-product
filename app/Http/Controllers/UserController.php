<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        return response()->json($users);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'client_id' => 'required|string|max:255',
            ]);
            $user = User::create($validatedData);
            return response()->json($user, 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'User creation failed',
                'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'email' => 'required|email|max:255',
                'client_id' => 'required|string|max:255',
            ]);
            $user = User::where('email', $validatedData['email'])
                ->where('client_id', $validatedData['client_id'])->first();
            if ($user) {
                return response()->json($user);
            } else {
                return response()->json(['message' => 'User not found'], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'User retrieval failed',
                'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'email' => 'required|email|max:255',
                'name' => 'sometimes|string|max:255',
            ]);
            $user = User::where('email', $validatedData['email'])
                ->where('client_id', $validatedData['client_id'])->first();
            if ($user) {
                $user->update($validatedData);
                return response()->json($user);
            } else {
                return response()->json(['message' => 'User not found'], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'User update failed',
                'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        try {
            $validatedData = $request->validate([
            'email' => 'required|email|max:255',
            ]);
            $user = User::where('email', $validatedData['email'])
                ->where('client_id', $validatedData['client_id'])->first();
            if ($user) {
                $user->delete();
                return response()->json(['message' => 'User deleted successfully']);
            } else {
                return response()->json(['message' => 'User not found'], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'User deletion failed',
                'error' => $e->getMessage()], 500);
        }
    }
}
