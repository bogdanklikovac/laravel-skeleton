<?php

namespace App\Http\Controllers\Api\V1\Author;

use App\Http\Controllers\Controller;
use App\Http\Resources\AuthorResource;
use App\Models\Author;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class RetrieveAuthor extends Controller
{
    /**
     * @OA\Get(
     *     tags={"Authors"},
     *     path="/api/v1/authors/{author}",
     *     operationId="getAuthor",
     *     summary="Get author",
     *     security={ {"sanctum": {} }},
     *     @OA\Parameter(
     *          name="author",
     *          in="path",
     *          description="Author id",
     *          required=true,
     *          example=1
     *      ),
     *     @OA\Response(
     *          response="200",
     *          description="success",
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
     *          response=404,
     *          description="Not found",
     *       ),
     * )
     */
    public function __invoke(Author $author): JsonResponse
    {
        return response()->json(new AuthorResource($author), Response::HTTP_OK);
    }
}
