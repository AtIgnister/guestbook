<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Helpers\IpHelper;

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
            //abort(403);
        }

        return $next($request);
    }
}
