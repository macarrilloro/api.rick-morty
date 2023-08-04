<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\CharacterResource;

class LocationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=> $this->id,
            'name' => $this->name,
            'type' => $this->type,
            'dimension' => $this->dimension,
            'slug' => $this->slug,
            'characters' => CharacterResource::collection($this->whenLoaded('characters'))
        ];
    }
}
