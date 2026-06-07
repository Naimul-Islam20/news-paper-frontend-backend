<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GalleryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'category' => optional($this->whenLoaded('category') ?? $this->category)->name,
            'description' => $this->description,
            'images' => GalleryImageResource::collection(
                $this->whenLoaded('images') ?? $this->images
            ),
        ];
    }
}

