<?php

namespace App\Http\Controllers\Api\V1\Tag;

use App\Http\Controllers\Controller;
use App\Http\Resources\TagResource;
use App\Models\Tag;
use Illuminate\Http\Resources\Json\ResourceCollection;

class RetrieveCollectionTag extends Controller
{
    /**
     * @OA\Get(
     *     tags={"Tags"},
     *     path="/api/v1/tags",
     *     operationId="getTags",
     *     summary="Get list of tags",
     *     security={ {"sanctum": {} }},
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
     * )
     */
    public function __invoke(): ResourceCollection
    {
        return TagResource::collection(Tag::all());
    }
}
