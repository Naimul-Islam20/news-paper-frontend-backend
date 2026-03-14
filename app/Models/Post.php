<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'title',
        'sub_title',
        'slug',
        'description',
        'image',
        'image_caption',
        'reporter_id',
        'seo_keywords',
        'status',
        'main_section_layer',
        'hero_layer',
        'views',
    ];

    protected $casts = [
        'views'      => 'integer',
        'hero_layer' => 'integer',
    ];

    public function reporter()
    {
        return $this->belongsTo(Reporter::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }
}
