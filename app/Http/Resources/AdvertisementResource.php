<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdvertisementResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $desktop = $this->image ? storage_image_url($this->image) : null;
        $mobileOnly = $this->image_mobile ? storage_image_url($this->image_mobile) : null;
        $videoDesktop = $this->video ? storage_image_url($this->video) : null;
        $videoMobile = $this->video_mobile ? storage_image_url($this->video_mobile) : null;

        return [
            'id' => $this->id,
            'slug' => $this->slug,
            'media_type' => $this->resolvedMediaType(),
            'image' => $desktop,
            'image_mobile' => $mobileOnly,
            'video' => $videoDesktop,
            'video_mobile' => $videoMobile,
            'video_youtube_id' => $this->video_youtube_id,
            /** মোবাইলে দেখানো URL: আলাদা মোবাইল ইমেজ না থাকলে ডেস্কটপ */
            'image_url_mobile' => $mobileOnly ?? $desktop,
            'video_url_mobile' => $videoMobile ?? $videoDesktop,
            'starts_at' => $this->starts_at?->toIso8601String(),
            'ends_at' => $this->ends_at?->toIso8601String(),
            'views_count' => (int) ($this->views_count ?? 0),
            'clicks_count' => (int) ($this->clicks_count ?? 0),
        ];
    }
}
