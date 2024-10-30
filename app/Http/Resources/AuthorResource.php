<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class AuthorResource
 * @OA\Schema(
 * )
 */
class AuthorResource extends JsonResource
{
    /**
     * @OA\Property(type="integer", default=1, property="id"),
     * @OA\Property(type="string", default="John", property="first_name"),
     * @OA\Property(type="string", default="Doe", property="last_name"),
     * @OA\Property(type="string", default="1980-01-23", property="birthday")
     * @OA\Property(type="string", default="John Doe was amazing author who ...", property="biography")
     * @OA\Property(type="string", default="London", property="place_of_birth")
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'birthday' => $this->birthday,
            'biography' => $this->biography,
            'place_of_birth' => $this->place_of_birth,
            'books' => BookResource::collection($this->whenLoaded('books')),
        ];
    }
}
