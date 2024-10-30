<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class UserResource
 * @OA\Schema(
 * )
 */
class UserResource extends JsonResource
{
    /**
     * @OA\Property(type="integer", default=1, property="id"),
     * @OA\Property(type="string", default="John", property="first_name"),
     * @OA\Property(type="string", default="Doe", property="last_name"),
     * @OA\Property(type="string", default="john.doe@q.agency", property="email")
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'role' => $this->roles->pluck('name'),
            'tags' => TagResource::collection($this->whenLoaded('tags')),
        ];
    }
}
