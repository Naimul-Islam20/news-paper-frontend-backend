<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VisitorDailyVisitor extends Model
{
    protected $fillable = [
        'date',
        'path',
        'visitor_id',
    ];

    protected $casts = [
        'date' => 'date',
    ];
}

