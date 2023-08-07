<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\EpisodeResource;
use App\Models\Episode;
use Illuminate\Http\Request;

class EpisodeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except(['index','show']);
        // $this->middleware('auth:api')->only(['store','update','destroy']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $episodes = Episode::included()
                    ->filter()
                    ->sort()
                    ->getOrPaginate();
        return EpisodeResource::collection($episodes);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'episode' => 'required|max:255',
            'slug' => 'required|max:255|unique:episodes',
        ]);
        $location = Episode::create($request->all());
        return EpisodeResource::make($location);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $Episode = Episode::included()->findOrFail($id);
        return EpisodeResource::make($Episode);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Episode $episode)
    {
        $request->validate([
            'name' => 'required|max:255',
            'episode' => 'required|max:255',
            'slug' => 'required|max:255|unique:episodes,slug,'.$episode->id,
        ]);
        $episode->update($request->all());
        return EpisodeResource::make($episode);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Episode $episode)
    {
        $episode->delete();
        return EpisodeResource::make($episode);
    }
}
