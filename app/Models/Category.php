<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    protected $fillable = ['name', 'type', 'description', 'slug', 'parent_id', 'status'];

    // Parent category
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    // Sub-categories
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id')->with('children');
    }

    public function subCategories()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    // Slug auto-generate
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });

        static::updating(function ($category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });
    }
}
