<?php

namespace App\Http\Controllers\Api\V1\Publisher;

use App\Http\Controllers\Controller;
use App\Http\Resources\PublisherResource;
use App\Models\Publisher;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class RetrievePublisher extends Controller
{
    /**
     * @OA\Get(
     *     tags={"Publishers"},
     *     path="/api/v1/publishers/{publisher}",
     *     operationId="getPublisher",
     *     summary="Get publisher",
     *     security={ {"sanctum": {} }},
     *     @OA\Parameter(
     *          name="publisher",
     *          in="path",
     *          description="Publisher id",
     *          required=true,
     *          example=1
     *      ),
     *     @OA\Response(
     *          response="200",
     *          description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="publisher", type="object", ref="#/components/schemas/PublisherResource")
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
        return response()->json(new PublisherResource($publisher), Response::HTTP_OK);
    }
}
