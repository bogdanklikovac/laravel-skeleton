<?php

namespace App\Http\Controllers\Api\V1\Tag;

use App\Http\Controllers\Controller;
use App\Http\Requests\TagRequest;
use App\Http\Resources\TagResource;
use App\Models\Tag;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class UpdateTag extends Controller
{
    /**
     * @OA\Put(
     *     tags={"Tags"},
     *     path="/api/v1/tags/{tag}",
     *     operationId="updateTag",
     *     summary="Update existing tag",
     *     security={ {"sanctum": {} }},
     *     @OA\Parameter(
     *          name="tag",
     *          in="path",
     *          description="Tag id",
     *          required=true,
     *          example=1
     *      ),
     *     @OA\RequestBody(
     *          required=true,
     *          description="Update existing tag",
     *          @OA\JsonContent(
     *              required={"name"},
     *              @OA\Property(property="name", type="string", example="Author"),
     *          ),
     *      ),
     *     @OA\Response(
     *          response=200,
     *          description="Tag updated successfully",
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
     *     @OA\Response(
     *          response=422,
     *          description="Validation failed"
     *      )
     * )
     */
    public function __invoke(TagRequest $request, Tag $tag): JsonResponse
    {
        $tag->update($request->all());

        return response()->json(new TagResource($tag), Response::HTTP_OK);
    }
}
