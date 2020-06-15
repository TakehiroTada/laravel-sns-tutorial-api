<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Exception;

/**
 * AuthController
 *
 * @author @TakehiroTada <taketada.works@gmail.com>
 */
class AuthController extends Controller
{
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['email', 'password']);

        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * register ユーザーの登録
     *
     * @param  mixed $request
     * @return void
     */
    public function register(Request $request)
    {
        $user = new User;
        try {
            $user = User::create($request->all());

            return response()->json(
                [
                    'message' => 'User created successfully',
                    'data' => $user
                ],
                201,
                [],
                JSON_UNESCAPED_UNICODE
            );
        } catch (Exception $e) {
            return response()->json(
                [
                    'message' => 'User create failed',
                ],
                500,
                [],
                JSON_UNESCAPED_UNICODE
            );
        }
    }

    /**
     * update【WIP】
     *
     * @param  mixed $request
     * @param  mixed $id
     * @return void
     */
    public function update(Request $request)
    {
        $user = auth()->user();
        $user->password = bcrypt($request->account_id);
        $user->last_name = $request->last_name;
        $user->first_name = $request->first_name;
        $user->last_name_kana = $request->last_name_kana;
        $user->first_name_kana = $request->first_name_kana;
        $user->update();
        return response()->json(
            [
                'message' => 'User updated successfully',
                'data' => $user
            ],
            201,
            [],
            JSON_UNESCAPED_UNICODE
        );
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
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
        return response()->json(
            [
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => auth()->factory()->getTTL() * 60
            ]
        );
    }
}
