<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
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
            'sub_title' => $this->sub_title,
            'slug' => $this->slug,
            'image' => $this->image,
            'image_caption' => $this->image_caption,
            'reporter' => optional($this->whenLoaded('reporter') ?? $this->reporter)->name,
            'categories' => CategoryResource::collection($this->whenLoaded('categories') ?? $this->categories),
            'status' => $this->status,
            'main_section_layer' => $this->main_section_layer,
            'created_at' => optional($this->created_at)?->toIso8601String(),
        ];
    }
}

