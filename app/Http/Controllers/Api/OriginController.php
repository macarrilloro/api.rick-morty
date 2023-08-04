<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CharacterResource;
use App\Http\Resources\OriginResource;
use App\Models\Origin;
use Illuminate\Http\Request;

class OriginController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except(['index','show']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $origin = Origin::included()
                    ->filter()
                    ->sort()
                    ->getOrPaginate();
        return OriginResource::collection($origin);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'location_id' => 'required|max:255',
        ]);
        $origin = Origin::create($data);
        return OriginResource::make($origin);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $character = Origin::included()->findOrFail($id);
        return OriginResource::make($character);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Origin $origin)
    {
        $data = $request->validate([
            'location_id' => 'required|max:255',
        ]);
        $origin->update($request->all());
        return OriginResource::make($origin);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Origin $origin)
    {
        $origin->delete();
        return OriginResource::make($origin);
    }
}
