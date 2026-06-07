<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VisitorStat extends Model
{
    protected $fillable = [
        'date',
        'path',
        'page_views',
        'unique_visitors',
    ];

    protected $casts = [
        'date'            => 'date',
        'page_views'      => 'integer',
        'unique_visitors' => 'integer',
    ];
}

