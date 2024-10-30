<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BookRequest extends FormRequest
{
    public function rules(): array
    {
        return match ($this->getMethod()) {
            'POST' => [
                'isbn' => ['required', 'size:17', Rule::unique('books', 'isbn')->ignore($this->book)],
                'title' => ['required', 'string'],
                'release_date' => ['date'],
                'format' => ['string'],
                'pages' => ['integer'],
                'publisher_id' => ['exists:publishers,id'],
                'authors' => ['array'],
                'authors.*' => ['exists:authors,id'],
            ],
            'PUT', 'PATCH' => [
                'isbn' => ['size:17', Rule::unique('books', 'isbn')->ignore($this->book)],
                'title' => ['string'],
                'release_date' => ['date'],
                'format' => ['string'],
                'pages' => ['integer'],
                'publisher_id' => ['exists:publishers,id'],
                'authors' => ['array'],
                'authors.*' => ['exists:authors,id'],
            ],
            default => []
        };
    }
}
