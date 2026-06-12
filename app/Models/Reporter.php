<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reporter extends Model
{
    protected static function booted(): void
    {
        static::creating(function (Reporter $reporter) {
            if (! $reporter->sub_editor_id) {
                throw new \InvalidArgumentException('Reporter requires a linked user.');
            }
        });

        static::updating(function (Reporter $reporter) {
            if (! $reporter->sub_editor_id) {
                throw new \InvalidArgumentException('Reporter requires a linked user.');
            }
        });
    }

    public function scopeLinkedToUser($query)
    {
        return $query->whereNotNull('sub_editor_id')
            ->whereHas('subEditor');
    }

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
