<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeLayoutSection extends Model
{
    protected $fillable = [
        'key',
        'label',
        'section_group',
        'category_id',
        'position',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}

