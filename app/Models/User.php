<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'reporter_id',
        'phone',
        'image',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isSeniorEditor(): bool
    {
        return $this->role === 'senior editor';
    }

    public function isSubEditor(): bool
    {
        return $this->role === 'sub editor';
    }

    public function isReporter(): bool
    {
        return $this->role === 'reporter';
    }

    public function reporter()
    {
        return $this->belongsTo(Reporter::class);
    }

    /**
     * Check if user has access to a given feature key using role_permissions table.
     */
    public function canFeature(string $featureKey): bool
    {
        // Admins are allowed everywhere by convention.
        if ($this->isAdmin()) {
            return true;
        }

        static $cache = [];
        $role = $this->role;

        if (! isset($cache[$role])) {
            /** @var \Illuminate\Support\Collection<int, \App\Models\RolePermission> $rolePerms */
            $rolePerms = RolePermission::query()
                ->where('role', $role)
                ->where('can_access', true)
                ->get();

            $cache[$role] = $rolePerms->pluck('can_access', 'feature_key')->map(fn() => true);
        }

        return (bool) ($cache[$role][$featureKey] ?? false);
    }
}
