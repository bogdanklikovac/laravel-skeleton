<?php

namespace App\Http\Controllers\Api\V1\Tag;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class DeleteTag extends Controller
{
    /**
     * @OA\Delete(
     *     tags={"Tags"},
     *     path="/api/v1/tags/{tag}",
     *     operationId="deleteTag",
     *     summary="Delete tag",
     *     security={ {"sanctum": {} }},
     *     @OA\Parameter(
     *          name="tag",
     *          in="path",
     *          description="Tag id",
     *          required=true,
     *          example=1
     *      ),
     *     @OA\Response(
     *          response="204",
     *          description="Deleted",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Tag deleted."),
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
        $tag->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
