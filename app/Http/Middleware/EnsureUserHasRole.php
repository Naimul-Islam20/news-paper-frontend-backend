<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (! Auth::check()) {
            return redirect()->route('admin.login');
        }

        $userRole = Auth::user()->role;

        // Laravel may pass "admin,senior editor,sub editor" as one string; normalize to array
        $allowed = [];
        foreach ($roles as $r) {
            foreach (array_map('trim', explode(',', $r)) as $part) {
                if ($part !== '') {
                    $allowed[] = $part;
                }
            }
        }
        $allowed = array_unique($allowed);

        if ($userRole === null || (! empty($allowed) && ! in_array($userRole, $allowed, true))) {
            abort(403);
        }

        return $next($request);
    }
}

