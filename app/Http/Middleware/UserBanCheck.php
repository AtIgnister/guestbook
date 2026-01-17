<?php

namespace App\Http\Middleware;

use App\Helpers\UserBanHelper;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class UserBanCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if (!$user) {
            abort(403); // user not authenticated
        }

        if (UserBanHelper::isBanned($user)) {
            // Return the banned view with 403 status
            return response()->view('users.banned', compact('user'), 403);
        }

        return $next($request);
    }
}
