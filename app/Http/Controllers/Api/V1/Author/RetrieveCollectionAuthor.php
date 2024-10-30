<?php

namespace App\Http\Controllers\Api\V1\Author;

use App\Http\Controllers\Controller;
use App\Http\Resources\AuthorResource;
use App\Models\Author;
use Illuminate\Http\Resources\Json\ResourceCollection;

class RetrieveCollectionAuthor extends Controller
{
    /**
     * @OA\Get(
     *     tags={"Authors"},
     *     path="/api/v1/authors",
     *     operationId="getAuthors",
     *     summary="Get list of authors",
     *     security={ {"sanctum": {} }},
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
     * )
     */
    public function __invoke(): ResourceCollection
    {
        return AuthorResource::collection(Author::with('books')->get());
    }
}
