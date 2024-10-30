<?php

namespace App\Http\Controllers\Api\V1\Tag;

use App\Http\Controllers\Controller;
use App\Http\Resources\TagResource;
use App\Models\Tag;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class RetrieveTag extends Controller
{
    /**
     * @OA\Get(
     *     tags={"Tags"},
     *     path="/api/v1/tags/{tag}",
     *     operationId="getTag",
     *     summary="Get tag data",
     *     security={ {"sanctum": {} }},
     *     @OA\Parameter(
     *          name="tag",
     *          in="path",
     *          description="Tag id",
     *          required=true,
     *          example=1
     *      ),
     *     @OA\Response(
     *          response="200",
     *          description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="tag", type="object", ref="#/components/schemas/TagResource")
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
    public function __invoke(Tag $tag): JsonResponse
    {
        return response()->json(new TagResource($tag), Response::HTTP_OK);
    }
}
