<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthorRequest extends FormRequest
{
    public function rules(): array
    {
        return match ($this->getMethod()) {
            'POST' => [
                'first_name' => ['required', 'string', 'min:3', 'max:255'],
                'last_name' => ['required', 'string', 'min:3', 'max:255'],
                'birthday' => ['date', 'nullable'],
                'biography' => ['string'],
                'place_of_birth' => ['string', 'min:3', 'max:255'],
            ],
            'PUT', 'PATCH' => [
                'first_name' => ['string', 'min:3', 'max:255'],
                'last_name' => ['string', 'min:3', 'max:255'],
                'birthday' => ['date', 'nullable'],
                'biography' => ['string'],
                'place_of_birth' => ['string', 'min:3', 'max:255'],
            ],
            default => []
        };
    }
}
