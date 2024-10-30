<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class BookResource
 * @OA\Schema(
 * )
 */
class BookResource extends JsonResource
{
    /**
     * @OA\Property(type="integer", default=1, property="id"),
     * @OA\Property(type="string", default="978-92-95055-02-5", property="isbn"),
     * @OA\Property(type="string", default="How to tie your shoes", property="title"),
     * @OA\Property(type="string", default="1999-25-11", property="release_date")
     * @OA\Property(type="string", default="PDF", property="format")
     * @OA\Property(type="integer", default="218", property="pages")
     * @OA\Property(property="publisher", ref="#/components/schemas/PublisherResource")
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'isbn' => $this->isbn,
            'title' => $this->title,
            'release_date' => $this->release_date,
            'format' => $this->format,
            'pages' => $this->pages,
            'publisher' => new PublisherResource($this->whenLoaded('publisher')),
            'authors' => AuthorResource::collection($this->whenLoaded('authors')),
        ];
    }
}
