<?php

namespace App\Http\Controllers\Api\V1\Tag;

use App\Http\Controllers\Controller;
use App\Http\Requests\TagRequest;
use App\Http\Resources\TagResource;
use App\Models\Tag;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class CreateTag extends Controller
{
    /**
     * @OA\Post(
     *     tags={"Tags"},
     *     path="/api/v1/tags",
     *     operationId="createTag",
     *     summary="Create new tag",
     *     security={ {"sanctum": {} }},
     *     @OA\RequestBody(
     *          required=true,
     *          description="Create new tag",
     *          @OA\JsonContent(
     *              required={"name"},
     *              @OA\Property(property="name", type="string", example="Author")
     *          ),
     *      ),
     *     @OA\Response(
     *          response=201,
     *          description="Tag created successfully",
     *          @OA\JsonContent(
     *              @OA\Property(property="tag", type="object", ref="#/components/schemas/TagResource")
     *          ),
     *      ),
     *     @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *     @OA\Response(
     *          response=422,
     *          description="Validation failed"
     *      )
     * )
     */
    public function __invoke(TagRequest $request): JsonResponse
    {
        $tag = Tag::create($request->all());

        return response()->json(new TagResource($tag), Response::HTTP_CREATED);
    }
}
