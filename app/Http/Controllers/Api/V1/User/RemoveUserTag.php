<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class RemoveUserTag extends Controller
{
    /**
     * @OA\Delete(
     *     tags={"Users"},
     *     path="/api/v1/users/{user}/tags/{tag}",
     *     operationId="removeUser",
     *     summary="Remove tag from user",
     *     security={ {"sanctum": {} }},
     *     @OA\Parameter(
     *          name="user",
     *          in="path",
     *          description="User id",
     *          required=true,
     *          example=1
     *      ),
     *     @OA\Parameter(
     *          name="tag",
     *          in="path",
     *          description="Tag id",
     *          required=true,
     *          example=1
     *      ),
     *     @OA\Response(
     *          response="200",
     *          description="Success",
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
    public function __invoke(User $user, Tag $tag): JsonResponse
    {
        if ($user->tags()->find($tag)) {
            $user->tags()->detach($tag);
        }

        return response()->json(new UserResource($user->with(['tags'])->firstOrFail()), Response::HTTP_OK);
    }
}
