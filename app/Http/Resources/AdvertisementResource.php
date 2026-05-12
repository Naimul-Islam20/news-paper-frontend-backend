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

        return [
            'id' => $this->id,
            'slug' => $this->slug,
            'image' => $desktop,
            'image_mobile' => $mobileOnly,
            /** মোবাইলে দেখানো URL: আলাদা মোবাইল ইমেজ না থাকলে ডেস্কটপ */
            'image_url_mobile' => $mobileOnly ?? $desktop,
        ];
    }
}

