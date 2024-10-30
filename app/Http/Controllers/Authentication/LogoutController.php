<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * @OA\Post(
 *      path="/api/v1/logout",
 *      operationId="logoutUser",
 *      tags={"Authentication"},
 *      summary="Logout user",
 *      description="Logout current user",
 *      security={ {"sanctum": {} }},
 *      @OA\Response(
 *          response=200,
 *          description="Successful operation",
 *       ),
 *      @OA\Response(
 *          response=400,
 *          description="Bad Request"
 *      ),
 *      @OA\Response(
 *          response=401,
 *          description="Unauthenticated",
 *      ),
 *      @OA\Response(
 *          response=403,
 *          description="Forbidden"
 *      )
 * )
 */
class LogoutController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        // Known issues in test :: Error: Call to a member function delete() on null
        // https://stackoverflow.com/questions/68255192/laravel-sanctum-delete-current-user-token-not-working
        // https://laracasts.com/discuss/channels/laravel/sanctum-logout-problem
        // https://github.com/laravel/sanctum/issues/48

        //        $request->user()->currentAccessToken()->delete();
        auth()->user()?->tokens()->where('id', auth()->id())->delete();

        return response()->json(['message' => 'User successfully signed out']);
    }
}
