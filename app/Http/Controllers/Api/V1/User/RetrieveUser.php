<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class RetrieveUser extends Controller
{
    /**
     * @OA\Get(
     *     tags={"Users"},
     *     path="/api/v1/users/{user}",
     *     operationId="getUserV1",
     *     summary="Get user data",
     *     security={ {"sanctum": {} }},
     *     @OA\Parameter(
     *          name="user",
     *          in="path",
     *          description="User id",
     *          required=true,
     *          example=1
     *      ),
     *     @OA\Response(
     *          response="200",
     *          description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="user", type="object", ref="#/components/schemas/UserResource")
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
        return response()->json(new UserResource($user), Response::HTTP_OK);
    }
}
