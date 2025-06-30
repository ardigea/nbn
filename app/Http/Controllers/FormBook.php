<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class FormBook extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('FormBook', [
            'event' => "test",
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the reservation data
        $validated = $request->validate([
            'restaurant' => 'required|string',
            'date' => 'required|integer',
            'month' => 'required|string',
            'year' => 'required|string',
            'time' => 'required|string',
            'people' => 'required|integer|min:1|max:10',
            'notes' => 'nullable|string',
            'fullName' => 'required|string|min:2',
            'phone' => 'required|string'
        ]);

        // Here you would typically save to database
        // For now, we'll just return a success response
        
        return response()->json([
            'success' => true,
            'message' => 'Reservation created successfully',
            'data' => $validated
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
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
