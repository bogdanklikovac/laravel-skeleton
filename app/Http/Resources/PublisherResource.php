<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class PublisherResource
 * @OA\Schema(
 * )
 */
class PublisherResource extends JsonResource
{
    /**
     * @OA\Property(type="integer", default=1, property="id"),
     * @OA\Property(type="string", default="Q Books Ltd", property="name"),
     * @OA\Property(type="string", default="5th Avenue, LA", property="address"),
     * @OA\Property(property="books", ref="#/components/schemas/BookResource")
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'address' => $this->address,
            'books' => BookResource::collection($this->whenLoaded('books')),
        ];
    }
}
