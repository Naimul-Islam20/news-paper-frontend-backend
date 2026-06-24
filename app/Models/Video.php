<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $fillable = [
        'category_id', 'reporter_id', 'created_by', 'edited_by', 'title', 'slug', 'youtube_link', 'image',
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

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function editor()
    {
        return $this->belongsTo(User::class, 'edited_by');
    }
}
