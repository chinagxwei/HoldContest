<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\JsonResponse;

//
class AdminAuthenticate extends Middleware
{
    /**
     * @param $request
     * @param Closure $next
     * @param ...$guards
     * @return Closure|JsonResponse|mixed
     */
    public function handle($request, Closure $next, ...$guards)
    {
        if (!$this->auth->guard('api')->check()) {
            return response()->json(['code' => 401, 'message' => '请先登录']);
        }
        /** @var User $user */
        if ($user = auth('api')->user()){
            // 检测是否是管理员
            if (!$user->isManager()&& !$user->isSuperManager()){
                return response()->json(['code' => 403, 'message' => '没有访问内容的权限']);
            }
        }

        return $next($request);
    }
}
