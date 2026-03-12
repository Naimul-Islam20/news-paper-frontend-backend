<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reporter extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'image',
        'status',
        'created_by'
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
