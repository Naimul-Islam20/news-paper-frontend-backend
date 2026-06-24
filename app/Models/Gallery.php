<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $fillable = ['category_id', 'reporter_id', 'created_by', 'edited_by', 'title', 'slug', 'status', 'description'];

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

    public function images()
    {
        return $this->hasMany(GalleryImage::class);
    }
}
