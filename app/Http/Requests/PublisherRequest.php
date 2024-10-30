<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PublisherRequest extends FormRequest
{
    public function rules(): array
    {
        return match ($this->getMethod()) {
            'POST' => [
                'name' => ['required', 'string'],
                'address' => ['string'],
            ],
            'PUT', 'PATCH' => [
                'name' => ['string'],
                'address' => ['string'],
            ],
            default => []
        };
    }
}
