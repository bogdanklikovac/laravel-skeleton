<?php

namespace App\Http\Controllers\Api\V1\Publisher;

use App\Http\Controllers\Controller;
use App\Models\Publisher;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class DeletePublisher extends Controller
{
    /**
     * @OA\Delete(
     *     tags={"Publishers"},
     *     path="/api/v1/publishers/{publisher}",
     *     operationId="deletePublisher",
     *     summary="Delete publisher",
     *     security={ {"sanctum": {} }},
     *     @OA\Parameter(
     *          name="publisher",
     *          in="path",
     *          description="Publisher id",
     *          required=true,
     *          example=1
     *      ),
     *     @OA\Response(
     *          response="204",
     *          description="Deleted",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Publisher deleted."),
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
    public function __invoke(Publisher $publisher): JsonResponse
    {
        $publisher->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
