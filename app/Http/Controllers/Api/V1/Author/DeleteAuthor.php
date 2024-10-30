<?php

namespace App\Http\Controllers\Api\V1\Author;

use App\Http\Controllers\Controller;
use App\Models\Author;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class DeleteAuthor extends Controller
{
    /**
     * @OA\Delete(
     *     tags={"Authors"},
     *     path="/api/v1/authors/{author}",
     *     operationId="deleteAuthor",
     *     summary="Delete author",
     *     security={ {"sanctum": {} }},
     *     @OA\Parameter(
     *          name="author",
     *          in="path",
     *          description="Author id",
     *          required=true,
     *          example=1
     *      ),
     *     @OA\Response(
     *          response="204",
     *          description="Deleted",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Author deleted."),
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
        $author->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
