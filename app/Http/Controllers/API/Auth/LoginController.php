<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

/**
 * @group Common Endpoints
 *
 * @subgroup Authentication
 *
 * @subgroupDescription The login and logout endpoints for all users.
 */
class LoginController extends Controller
{
    /**
     * Login
     *
     * Login the user into the application. Once logged in, it will generate a bearer token and send it in the response.
     * This token should be used for making further requests.
     *
     * @unauthenticated
     *
     * @param  LoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postLogin(LoginRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        $passwordMatches = Hash::check($request->password, $user->password);
        if (! $passwordMatches) {
            return response()->json([
                'status' => 'failed',
                'message' => 'The provided credentials are invalid.',
            ], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'status' => 'success',
            'message' => 'User logged in successfully.',
            'data' => [
                'token' => $token,
                'user' => $user,
            ]
        ], 200);
    }
}
