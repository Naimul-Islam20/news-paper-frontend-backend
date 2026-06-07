<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserCanFeature
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $featureKey): Response
    {
        if (! Auth::check()) {
            return redirect()->route('admin.login');
        }

        /** @var User|null $user */
        $user = Auth::user();

        if (! $user || ! $user->canFeature($featureKey)) {
            abort(403);
        }

        return $next($request);
    }
}

