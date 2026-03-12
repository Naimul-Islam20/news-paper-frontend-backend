<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VideoResource extends JsonResource
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
            'youtube_link' => $this->youtube_link,
            'image' => $this->image,
            'category' => optional($this->whenLoaded('category') ?? $this->category)->name,
            'status' => $this->status,
            'is_main_video' => $this->is_main_video,
            'created_at' => optional($this->created_at)?->toIso8601String(),
        ];
    }
}

