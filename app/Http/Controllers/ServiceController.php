<?php

namespace App\Http\Controllers;

use App\Models\Service;

use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('service.create-service');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Service::create([
            'service_name' => $request->service_name,
            'hourly_rate' => $request->hourly_rate,
            'description' => $request->description,
        ]);

        return back()->with(['success' => 'Service added successfuly.....!']);
    }

    public function fetchHourlyRate($id)
    {
        $service = Service::where('id', $id)->first();
        if ($service) {
            return response()->json(['hourly_rate' => $service->hourly_rate]);
        }
        return response()->json(['error' => 'Service not found'], 404);
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
