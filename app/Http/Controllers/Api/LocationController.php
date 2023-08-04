<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Location;
use Illuminate\Http\Request;
use App\Http\Resources\LocationResource;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $locations = Location::included()
                    ->filter()
                    ->sort()
                    ->getOrPaginate();
        return LocationResource::collection($locations);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'type' => 'required|max:255',
            'dimension' => 'required|max:255',
            'slug' => 'required|max:255|unique:Locations',
        ]);
        $location = Location::create($request->all());
        return LocationResource::make($location);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $location = Location::included()->findOrFail($id);
        return LocationResource::make($location);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Location $location)
    {

        $request->validate([
            'name' => 'required|max:255',
            'type' => 'required|max:255',
            'dimension' => 'required|max:255',
            'slug' => 'required|max:255|unique:locations,slug,'.$location->id,
        ]);
        $location->update($request->all());
        return LocationResource::make($location);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Location $location)
    {
        $location->delete();
        return LocationResource::make($location);
    }
}
