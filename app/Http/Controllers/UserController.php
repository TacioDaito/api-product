<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $headerValidator = Validator::make($request->headers->all(), [
            'client-id' => 'required|max:255',
        ]);
        if ($headerValidator->fails()) {
            return response()->json(['message' => 'Header validation failed',
                'error' => $headerValidator->errors()->first()], 400);
        }
        try {
            $users = User::where('client-id', $request->header('client-id'))
                ->get();
            if ($users) {
                return response()->json($users);
            } else {
                return response()->json(['message' => 'No users found'], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'User retrieval failed',
                'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $headerValidator = Validator::make($request->headers->all(), [
            'client-id' => 'required|max:255',
        ]);
        if ($headerValidator->fails()) {
            return response()->json(['message' => 'Header validation failed',
                'error' => $headerValidator->errors()->first()], 400);
        }
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|max:255',
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Validation failed',
                'error' => $e->getMessage()], 400);
        }
        try {
            $validatedData['client-id'] = $request->header('client-id');
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
        $headerValidator = Validator::make($request->headers->all(), [
            'email' => 'required|max:255',
            'client-id' => 'required|max:255',
        ]);
        if ($headerValidator->fails()) {
            return response()->json(['message' => 'Header validation failed',
                'error' => $headerValidator->errors()->first()], 400);
        }
        try {
            $user = User::where('email', $request->header('email'))
                ->where('client-id', $request->header('client-id'))->first();
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
        $headerValidator = Validator::make($request->headers->all(), [
            'client-id' => 'required|max:255',
        ]);
        if ($headerValidator->fails()) {
            return response()->json(['message' => 'Header validation failed',
                'error' => $headerValidator->errors()->first()], 400);
        }
        try {
            $validatedData = $request->validate([
                'email' => 'required|max:255',
                'name' => 'sometimes|string|max:255',
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Validation failed',
                'error' => $e->getMessage()], 400);
        }
        try {
            $validatedData['client-id'] = $request->header('client-id');
            $user = User::where('email', $validatedData['email'])
                ->where('client-id', $validatedData['client-id'])->first();
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
        $headerValidator = Validator::make($request->headers->all(), [
            'email' => 'required|max:255',
            'client-id' => 'required|max:255',
        ]);
        if ($headerValidator->fails()) {
            return response()->json(['message' => 'Header validation failed',
                'error' => $headerValidator->errors()->first()], 400);
        }
        try {
            $user = User::where('email', $request->header('email'))
                ->where('client-id', $request->header('client-id'))->first();
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
