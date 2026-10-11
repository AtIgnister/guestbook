<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Helpers\IpHelper;

/**
 * Middleware to check if the request is coming from a banned IP address, or trying to access a guestbook that has banned the IP address.
 * For non-guestbook routes, use "UserBanCheck" instead. TODO: rename this middleware to something more sensible.
 */
class BanCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ?string $guestbookParam = null): Response
    {
        $guestbook = $guestbookParam
            ? $request->route($guestbookParam)
            : null;

        if(IpHelper::isBanned($request, $guestbook)) {
            abort(403);
        }

        return $next($request);
    }
}
