<?php

namespace Database\Seeders;

use App\Models\RolePermission;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        $roles = config('role_permissions.roles', []);
        $featureKeys = array_keys(config('role_permissions.feature_keys', []));

        $defaults = [
            'admin' => array_fill_keys($featureKeys, true),
            'senior editor' => [
                'users.manage' => false,
                'posts.view' => true,
                'posts.manage' => true,
                'categories.manage' => true,
                'galleries.manage' => true,
                'videos.manage' => true,
                'reporters.manage' => true,
                'pages.manage' => true,
                'advertisements.manage' => false,
                'settings.meta' => false,
                'settings.layout' => false,
                'statistics.view' => true,
                'subscribes.view' => false,
                'role_permissions.manage' => false,
            ],
            'sub editor' => [
                'users.manage' => false,
                'posts.view' => true,
                'posts.manage' => true,
                'categories.manage' => false,
                'galleries.manage' => false,
                'videos.manage' => false,
                'reporters.manage' => false,
                'pages.manage' => false,
                'advertisements.manage' => false,
                'settings.meta' => false,
                'settings.layout' => false,
                'statistics.view' => false,
                'subscribes.view' => false,
                'role_permissions.manage' => false,
            ],
        ];

        foreach (array_keys($roles) as $role) {
            foreach ($featureKeys as $key) {
                $canAccess = $defaults[$role][$key] ?? ($role === 'admin');
                RolePermission::query()->updateOrCreate(
                    ['role' => $role, 'feature_key' => $key],
                    ['can_access' => $canAccess]
                );
            }
        }
    }
}
