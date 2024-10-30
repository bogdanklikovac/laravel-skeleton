<?php

namespace App\Http\Controllers\Api\V1\Book;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class DeleteBook extends Controller
{
    /**
     * @OA\Delete(
     *     tags={"Books"},
     *     path="/api/v1/books/{book}",
     *     operationId="deleteBook",
     *     summary="Delete book",
     *     security={ {"sanctum": {} }},
     *     @OA\Parameter(
     *          name="book",
     *          in="path",
     *          description="Book id",
     *          required=true,
     *          example=1
     *      ),
     *     @OA\Response(
     *          response="204",
     *          description="Deleted",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Book deleted."),
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
        $book->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
