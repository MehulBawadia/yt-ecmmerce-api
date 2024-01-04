<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * @group Common Endpoints
 *
 * @subgroup Authentication
 *
 * @subgroupDescription The login and logout endpoints for all users.
 */
class LogoutController extends Controller
{
    /**
     * Logout
     *
     * Logout the user from the application. This will delete all the tokens created when user logged in.
     *
     * @authenticated
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'User successfully logged out.',
        ], 200);
    }
}
