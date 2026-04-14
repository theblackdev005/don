<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

/** Doit être utilisé après le middleware auth : vérifie le rôle administrateur. */
class EnsureAdminAuthenticated
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if (! $user instanceof User || ! $user->isAdmin()) {
            if ($user) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
            }

            return redirect()
                ->route('admin.login')
                ->withErrors(['email' => 'Ce compte n’a pas accès à l’administration.']);
        }

        return $next($request);
    }
}
