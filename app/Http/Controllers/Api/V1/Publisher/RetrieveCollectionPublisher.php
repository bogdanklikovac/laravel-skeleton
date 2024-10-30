<?php

namespace App\Http\Controllers\Api\V1\Publisher;

use App\Http\Controllers\Controller;
use App\Http\Resources\PublisherResource;
use App\Models\Publisher;
use Illuminate\Http\Resources\Json\ResourceCollection;

class RetrieveCollectionPublisher extends Controller
{
    /**
     * @OA\Get(
     *     tags={"Publishers"},
     *     path="/api/v1/publishers",
     *     operationId="getPublishers",
     *     summary="Get list of publishers",
     *     security={ {"sanctum": {} }},
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
     * )
     */
    public function __invoke(): ResourceCollection
    {
        return PublisherResource::collection(Publisher::with('books')->get());
    }
}
