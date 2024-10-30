<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class TagResource
 * @OA\Schema(
 * )
 */
class TagResource extends JsonResource
{
    /**
     * @OA\Property(type="integer", default=1, property="id"),
     * @OA\Property(type="string", default="Author", property="name")
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
        ];
    }
}
