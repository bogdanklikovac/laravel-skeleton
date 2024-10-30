<?php

namespace App\Http\Controllers\Api\V1\Publisher;

use App\Http\Controllers\Controller;
use App\Http\Requests\PublisherRequest;
use App\Http\Resources\PublisherResource;
use App\Models\Publisher;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class UpdatePublisher extends Controller
{
    /**
     * @OA\Put(
     *     tags={"Publishers"},
     *     path="/api/v1/publishers/{publisher}",
     *     operationId="updatePublisher",
     *     summary="Update existing publisher",
     *     security={ {"sanctum": {} }},
     *     @OA\Parameter(
     *          name="publisher",
     *          in="path",
     *          description="Publisher id",
     *          required=true,
     *          example=1
     *      ),
     *     @OA\RequestBody(
     *          required=true,
     *          description="Update existing publisher",
     *          @OA\JsonContent(
     *              required={"name"},
     *              @OA\Property(property="name", type="string", example="Q Publishing"),
     *              @OA\Property(property="address", type="string", example="Some address 33"),
     *          ),
     *      ),
     *     @OA\Response(
     *          response=200,
     *          description="Publisher updated successfully",
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
     *     @OA\Response(
     *          response=422,
     *          description="Validation failed"
     *      )
     * )
     */
    public function __invoke(PublisherRequest $request, Publisher $publisher): JsonResponse
    {
        $publisher->update($request->all());

        return response()->json(new PublisherResource($publisher), Response::HTTP_OK);
    }
}
