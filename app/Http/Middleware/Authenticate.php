<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{

    /**
     * @param $request
     * @param Closure $next
     * @param ...$guards
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function handle($request, Closure $next, ...$guards)
    {
        if (!$this->auth->guard('api')->check()) {
            return response()->json(['code' => 403, 'message' => '请先登录']);
        }
        return $next($request);
    }
}
