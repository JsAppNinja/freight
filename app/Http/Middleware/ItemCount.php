<?php

namespace App\Http\Middleware;

use Closure;

class ItemCount
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (isset($request->thirdParty)) {
            if (count($request->item) > 0) {
                $request->attributes->add(array('count' => count($request->item)));
                return $next($request);
            }
        }
    }
}
