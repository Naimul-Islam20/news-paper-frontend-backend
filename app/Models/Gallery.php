<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $fillable = ['category_id', 'reporter_id', 'title', 'slug', 'status', 'description'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function reporter()
    {
        return $this->belongsTo(Reporter::class);
    }

    public function images()
    {
        return $this->hasMany(GalleryImage::class);
    }
}
