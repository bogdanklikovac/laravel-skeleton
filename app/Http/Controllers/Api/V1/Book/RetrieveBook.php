<?php

namespace App\Http\Controllers\Api\V1\Book;

use App\Http\Controllers\Controller;
use App\Http\Resources\BookResource;
use App\Models\Book;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class RetrieveBook extends Controller
{
    /**
     * @OA\Get(
     *     tags={"Books"},
     *     path="/api/v1/books/{book}",
     *     operationId="getBook",
     *     summary="Get book",
     *     security={ {"sanctum": {} }},
     *     @OA\Parameter(
     *          name="book",
     *          in="path",
     *          description="Book id",
     *          required=true,
     *          example=1
     *      ),
     *     @OA\Response(
     *          response="200",
     *          description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="book", type="object", ref="#/components/schemas/BookResource")
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
    public function __invoke(Book $book): JsonResponse
    {
        return response()->json(new BookResource($book), Response::HTTP_OK);
    }
}
