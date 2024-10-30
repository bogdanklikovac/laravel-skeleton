<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Resources\Json\ResourceCollection;

class RetrieveCollectionUser extends Controller
{
    /**
     * @OA\Get(
     *     tags={"Users"},
     *     path="/api/v1/users",
     *     operationId="getUsersV1",
     *     summary="Get list of users",
     *     security={ {"sanctum": {} }},
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
     * )
     */
    public function __invoke(): ResourceCollection
    {
        return UserResource::collection(User::all());
    }
}
