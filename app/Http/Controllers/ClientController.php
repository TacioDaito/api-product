<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Client;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $clients = Client::all();
            if ($clients) {
                return response()->json($clients);
            } else {
                return response()->json(['message' => 'No clients found'], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Client retrieval failed',
                'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|max:255',
                'phone' => 'sometimes|max:15',
                'address' => 'sometimes|max:255',
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Validation failed',
                'error' => $e->getMessage()], 400);
        }
        try {
            $client = Client::create($validatedData);
            return response()->json($client, 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Client creation failed',
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
        ]);
        if ($headerValidator->fails()) {
            return response()->json(['message' => 'Header validation failed',
                'error' => $headerValidator->errors()->first()], 400);
        }
        try {
            $client = Client::where('email', $request->header('email'))->first();
            if ($client) {
                return response()->json($client);
            } else {
                return response()->json(['message' => 'Client not found'], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Client retrieval failed',
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
                'email' => 'required|max:255',
                'name' => 'sometimes|string|max:255',
                'phone' => 'sometimes|max:15',
                'address' => 'sometimes|max:255',
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Validation failed',
                'error' => $e->getMessage()], 400);
        }
        try {
            $client = Client::where('email', $validatedData['email'])->first();
            if ($client) {
                $client->update($validatedData);
                return response()->json($client);
            } else {
                return response()->json(['message' => 'Client not found'], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Client update failed',
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
        ]);
        if ($headerValidator->fails()) {
            return response()->json(['message' => 'Header validation failed',
                'error' => $headerValidator->errors()->first()], 400);
        }
        try {
            $client = Client::where('email', $request->header('email'))->first();
            if ($client) {
                $client->delete();
                return response()->json(['message' => 'Client deleted successfully']);
            } else {
                return response()->json(['message' => 'Client not found'], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Client deletion failed',
                'error' => $e->getMessage()], 500);
        }
    }
}
