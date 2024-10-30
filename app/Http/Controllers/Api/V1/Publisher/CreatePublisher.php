<?php

namespace App\Http\Controllers\Api\V1\Publisher;

use App\Http\Controllers\Controller;
use App\Http\Requests\PublisherRequest;
use App\Http\Resources\PublisherResource;
use App\Models\Publisher;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class CreatePublisher extends Controller
{
    /**
     * @OA\Post(
     *     tags={"Publishers"},
     *     path="/api/v1/publishers",
     *     operationId="createPublisher",
     *     summary="Create new publisher",
     *     security={ {"sanctum": {} }},
     *     @OA\RequestBody(
     *          required=true,
     *          description="Create new publisher",
     *          @OA\JsonContent(
     *              required={"name"},
     *              @OA\Property(property="name", type="string", example="Q Publishing"),
     *              @OA\Property(property="address", type="string", example="Some address 33"),
     *          ),
     *      ),
     *     @OA\Response(
     *          response=201,
     *          description="Publisher created successfully",
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
     *          response=422,
     *          description="Validation failed"
     *      ),
     * )
     */
    public function __invoke(PublisherRequest $request): JsonResponse
    {
        $publisher = Publisher::create($request->all());

        return response()->json(new PublisherResource($publisher), Response::HTTP_CREATED);
    }
}
