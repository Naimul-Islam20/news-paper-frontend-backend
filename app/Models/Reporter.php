<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reporter extends Model
{
    protected $fillable = [
        'name',
        'desk',
        'sub_editor_id',
        'email',
        'password',
        'phone',
        'address',
        'image',
        'status',
        'created_by'
    ];

    protected $hidden = ['password'];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function subEditor()
    {
        return $this->belongsTo(User::class, 'sub_editor_id');
    }
}
