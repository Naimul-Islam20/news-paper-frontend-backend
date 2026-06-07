<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RolePermission;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class RolePermissionController extends Controller
{
    public function index(): View
    {
        $roles = config('role_permissions.roles', []);
        $featureKeys = config('role_permissions.feature_keys', []);

        $permissions = RolePermission::query()
            ->get()
            ->groupBy('role')
            ->map(fn ($items) => $items->pluck('can_access', 'feature_key')->toArray());

        return view('admin.role-permissions.index', [
            'roles'        => $roles,
            'featureKeys'  => $featureKeys,
            'permissions'  => $permissions->toArray(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'permissions' => ['nullable', 'array'],
        ]);

        $roles = array_keys(config('role_permissions.roles', []));
        $featureKeys = array_keys(config('role_permissions.feature_keys', []));
        // Read raw array so keys with dots (e.g. posts.view) are not split by Laravel's dot notation
        $submitted = $request->input('permissions', []);

        DB::transaction(function () use ($submitted, $roles, $featureKeys): void {
            foreach ($roles as $role) {
                foreach ($featureKeys as $key) {
                    $checked = isset($submitted[$role][$key]) && $submitted[$role][$key];

                    RolePermission::query()->updateOrCreate(
                        [
                            'role'        => $role,
                            'feature_key' => $key,
                        ],
                        ['can_access' => $checked]
                    );
                }
            }
        });

        return redirect()->route('admin.role-permissions.index')
            ->with('success', 'Role access updated successfully.');
    }
}
