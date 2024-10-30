<?php

namespace App\Http\Controllers\Api\V1\Book;

use App\Http\Controllers\Controller;
use App\Http\Resources\BookResource;
use App\Models\Book;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Response;

class RetrieveCollectionBook extends Controller
{
    /**
     * @OA\Get(
     *     tags={"Books"},
     *     path="/api/v1/books",
     *     operationId="getBooks",
     *     summary="Get list of books",
     *     security={ {"sanctum": {} }},
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
     * )
     */
    public function __invoke(): ResourceCollection
    {
        return BookResource::collection(Book::with('authors', 'publisher')->get());
    }
}
