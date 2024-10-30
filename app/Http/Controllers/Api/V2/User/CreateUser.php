<?php

namespace App\Http\Controllers\Api\V2\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class CreateUser extends Controller
{
    /**
     * @OA\Post(
     *     tags={"Users"},
     *     path="/api/v2/users",
     *     operationId="createUserV2",
     *     summary="Create new user",
     *     @OA\RequestBody(
     *          required=true,
     *          description="Create new user",
     *          @OA\JsonContent(
     *              required={"first_name", "last_name", "email", "password"},
     *              @OA\Property(property="first_name", type="string", example="John"),
     *              @OA\Property(property="last_name", type="string", example="Doe"),
     *              @OA\Property(property="email", type="string", example="john.doe@q.agency"),
     *              @OA\Property(property="password", type="string", example="secretPassword")
     *          ),
     *      ),
     *     @OA\Response(
     *          response=201,
     *          description="User created successfully",
     *          @OA\JsonContent(
     *              @OA\Property(property="user", type="object", ref="#/components/schemas/UserResource")
     *          ),
     *      ),
     *     @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *     @OA\Response(
     *          response=422,
     *          description="Validation failed"
     *      )
     * )
     */
    public function __invoke(UserRequest $request): JsonResponse
    {
        $user = User::create($request->all());
        $user->assignRole($request->role ?? User::ROLE_USER);

        return response()->json(new UserResource($user), Response::HTTP_CREATED);
    }
}
