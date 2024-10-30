<?php

namespace App\Http\Controllers\Api\V1\Author;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthorRequest;
use App\Http\Resources\AuthorResource;
use App\Models\Author;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class CreateAuthor extends Controller
{
    /**
     * @OA\Post(
     *     tags={"Authors"},
     *     path="/api/v1/authors",
     *     operationId="createAuthor",
     *     summary="Create new author",
     *     security={ {"sanctum": {} }},
     *     @OA\RequestBody(
     *          required=true,
     *          description="Create new author",
     *          @OA\JsonContent(
     *              required={"first_name", "last_name"},
     *              @OA\Property(property="first_name", type="string", example="John"),
     *              @OA\Property(property="last_name", type="string", example="Doe"),
     *              @OA\Property(property="birthday", type="string", example="1980-01-23"),
     *              @OA\Property(property="biography", type="string", example="John Doe was amazing author who ..."),
     *              @OA\Property(property="place_of_birth", type="string", example="London"),
     *          ),
     *      ),
     *     @OA\Response(
     *          response=201,
     *          description="Author created successfully",
     *          @OA\JsonContent(
     *              @OA\Property(property="author", type="object", ref="#/components/schemas/AuthorResource")
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
     * )
     */
    public function __invoke(AuthorRequest $request): JsonResponse
    {
        $author = Author::create($request->all());

        return response()->json(new AuthorResource($author), Response::HTTP_CREATED);
    }
}
