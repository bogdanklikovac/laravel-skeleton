<?php

namespace App\Http\Controllers\Api\V1\Book;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookRequest;
use App\Http\Resources\BookResource;
use App\Models\Book;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class CreateBook extends Controller
{
    /**
     * @OA\Post(
     *     tags={"Books"},
     *     path="/api/v1/books",
     *     operationId="createBook",
     *     summary="Create new book",
     *     security={ {"sanctum": {} }},
     *     @OA\RequestBody(
     *          required=true,
     *          description="Create new book",
     *          @OA\JsonContent(
     *              required={"isbn", "title"},
     *              @OA\Property(property="isbn", type="string", example="978-92-95055-02-5"),
     *              @OA\Property(property="title", type="string", example="How to tie your shoes"),
     *              @OA\Property(property="release_date", type="string", example="1999-11-25"),
     *              @OA\Property(property="format", type="string", example="PDF"),
     *              @OA\Property(property="pages", type="integer", example="218"),
     *              @OA\Property(property="publisher_id", type="integer", example="1"),
     *          ),
     *      ),
     *     @OA\Response(
     *          response=201,
     *          description="Book created successfully",
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
     *          response=422,
     *          description="Validation failed"
     *      ),
     * )
     */
    public function __invoke(BookRequest $request): JsonResponse
    {
        $book = Book::create($request->all());

        return response()->json(new BookResource($book), Response::HTTP_CREATED);
    }
}
