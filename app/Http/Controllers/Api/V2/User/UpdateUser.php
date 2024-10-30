<?php

namespace App\Http\Controllers\Api\V2\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class UpdateUser extends Controller
{
    /**
     * @OA\Put(
     *     tags={"Users"},
     *     path="/api/v2/users/{user}",
     *     operationId="updateUserV2",
     *     summary="Update existing user",
     *     security={ {"sanctum": {} }},
     *     @OA\Parameter(
     *          name="user",
     *          in="path",
     *          description="User id",
     *          required=true,
     *          example=1
     *      ),
     *     @OA\RequestBody(
     *          required=true,
     *          description="Update existing user",
     *          @OA\JsonContent(
     *              required={"first_name", "last_name", "email", "password"},
     *              @OA\Property(property="first_name", type="string", example="John"),
     *              @OA\Property(property="last_name", type="string", example="Doe"),
     *              @OA\Property(property="email", type="string", example="john.doe@q.agency"),
     *              @OA\Property(property="password", type="string", example="secretPassword")
     *          ),
     *      ),
     *     @OA\Response(
     *          response=200,
     *          description="User updated successfully",
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
     *          response=422,
     *          description="Validation failed"
     *      ),
     *     @OA\Response(
     *          response=404,
     *          description="Not found",
     *       ),
     * )
     */
    public function __invoke(UserRequest $request, User $user): JsonResponse
    {
        $user->update($request->all());
        $user->assignRole($request->role ?? User::ROLE_USER);

        return response()->json(new UserResource($user), Response::HTTP_OK);
    }
}
