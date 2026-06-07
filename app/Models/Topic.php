<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    protected $fillable = ['name', 'slug', 'can_delete'];

    public function posts()
    {
        return $this->belongsToMany(Post::class);
    }
}
