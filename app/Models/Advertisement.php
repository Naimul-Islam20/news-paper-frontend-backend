<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Advertisement extends Model
{
    protected $fillable = ['slug', 'name', 'image', 'link', 'caption', 'video_youtube_id'];

    /**
     * Get ad slot by slug (for frontend and views).
     */
    public static function getBySlug(string $slug): ?self
    {
        return static::where('slug', $slug)->first();
    }
}
