<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RolePermission extends Model
{
    protected $fillable = [
        'role',
        'feature_key',
        'can_access',
    ];

    protected $casts = [
        'can_access' => 'boolean',
    ];
}

