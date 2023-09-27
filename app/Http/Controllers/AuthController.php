<?php

namespace App\Http\Controllers;

use App\Models\Admin\Admin;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class AuthController extends PlatformController
{

    protected $controller_event_text = "认证";

    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function login(Request $request)
    {
        $credentials = request(['username', 'password']);

        if (!$token = auth('api')->attempt($credentials)) {
            return self::failJsonResponse('用户名或密码错误');
        }

        return $this->respondWithToken($token);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function register(Request $request)
    {
        if ($request->isMethod("POST")) {
            DB::beginTransaction();
            try {
                $this->validate($request, [
                    'username' => 'required|min:5',
                    'password' => 'required|min:6',
                ]);
                $user = new User();

                $user->registerMember($request->all());

                Admin::generate($user->id);

                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                return self::failJsonResponse($e->getMessage());
            }
        }
        return self::successJsonResponse();
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function resetPassword(Request $request)
    {
        if ($request->isMethod("POST")) {
            DB::beginTransaction();
            try {
                $this->validate($request, [
                    'oldPassword' => 'required',
                    'newPassword' => 'required',
                ]);
                $credentials = request(['username', 'password']);
                if (auth('api')->validate($credentials)){
                    $user = auth('api')->user();
                    $user->resetPassword($request->post('newPassword'));
                }
                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                return self::failJsonResponse($e->getMessage());
            }
        }
        return self::successJsonResponse();
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function info()
    {
        /** @var User $user */
        $user = auth('api')->user();
        if ($admin = $user->admin) {
            $admin->role->navigations;
            return self::successJsonResponse($admin);
        }

        return self::failJsonResponse('Not Found');
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth('api')->logout();

        return self::successJsonResponse();
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth('api')->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        $user = auth('api')->user();
        /** @var Admin $admin */
        $admin = $user->admin;
        if ($admin) {
            $admin->role->navigations;
        }
        return self::successJsonResponse([
            'userinfo' => $admin,
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => time() + auth('api')->factory()->getTTL() * 60
        ]);
    }
}
