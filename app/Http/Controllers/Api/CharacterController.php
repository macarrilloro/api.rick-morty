<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CharacterResource;
use App\Models\Character;
use Illuminate\Http\Request;

class CharacterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $characters = Character::included()
                    ->filter()
                    ->sort()
                    ->getOrPaginate();
        return CharacterResource::collection($characters);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|max:255',
            'status' => 'required|max:255',
            'species' => 'required|max:255',
            'gender' => 'required|max:255',
            'slug' => 'required|max:255|unique:characters',
            'origin' => 'required|exists:locations,id',
        ]);
        $user = auth()->user();
        $data['user_id'] = $user->id;
        $data['location_id'] = $request->origin;
        $characters = Character::create($data);
        $characters->locations()->attach($request->location_id);
        $characters->episodes()->attach($request->episodes);
        return CharacterResource::make($characters);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $character = Character::included()->findOrFail($id);
        return CharacterResource::make($character);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Character $character)
    {
        $request->validate([
            'name' => 'required|max:255',
            'status' => 'required|max:255',
            'species' => 'required|max:255',
            'gender' => 'required|max:255',
            'slug' => 'required|max:255|unique:characters,slug,'. $character->id,
            'origin' => 'required|exists:locations,id',
        ]);
        $origin = $request->origin;
        $character->locations()->detach();
        $character->locations()->attach($request->location_id);
        $character->episodes()->detach();
        $character->episodes()->attach($request->episodes);
        $request['location_id'] = $origin;
        $character->update($request->all());
        return CharacterResource::make($character);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Character $character)
    {
        $character->delete();
        return CharacterResource::make($character);
    }
}
