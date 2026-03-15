<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $fillable = [
        'category_id', 'reporter_id', 'title', 'slug', 'youtube_link', 'image',
        'description', 'status', 'is_main_video',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function reporter()
    {
        return $this->belongsTo(Reporter::class);
    }
}
