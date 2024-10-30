<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class DeleteUser extends Controller
{
    /**
     * @OA\Delete(
     *     tags={"Users"},
     *     path="/api/v1/users/{user}",
     *     operationId="deleteUserV1",
     *     summary="Delete user",
     *     security={ {"sanctum": {} }},
     *     @OA\Parameter(
     *          name="user",
     *          in="path",
     *          description="User id",
     *          required=true,
     *          example=1
     *      ),
     *     @OA\Response(
     *          response="204",
     *          description="Deleted",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="User deleted."),
     *          ),
     *      ),
     *     @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthorized",
     *       ),
     *     @OA\Response(
     *          response=404,
     *          description="Not found",
     *       ),
     * )
     */
    public function __invoke(User $user): JsonResponse
    {
        $user->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
