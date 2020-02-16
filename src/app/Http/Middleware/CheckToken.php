<?php

namespace App\Http\Middleware;

use App\Http\Resources\BaseResource;
use App\User;
use Closure;
use Illuminate\Validation\UnauthorizedException;

class CheckToken
{
    /**
     * api isteklerinde token kontrolü yapar
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->headers->has('token')) {
            $user = User::where('api_token', $request->headers->get('token'))->first();
            if ($user) {
                return $next($request);
            }
        }
        return new BaseResource(null, 401, "UnAuthorize");
    }
}
