<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return match ($this->getMethod()) {
            'POST' => true,
            'PUT', 'PATCH' => $this->user()->can('update', User::class),
            'DELETE' => $this->user()->can('delete', User::class),
            default => false
        };
    }

    public function rules(): array
    {
        return match ($this->getMethod()) {
            'POST' => [
                'first_name' => ['required', 'string'],
                'last_name' => ['required', 'string'],
                'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($this->user)],
                'password' => ['required', 'string'],
                'role' => ['string', Rule::in(User::ROLES)],
            ],
            'PUT', 'PATCH' => [
                'first_name' => ['string'],
                'last_name' => ['string'],
                'email' => ['email', Rule::unique('users', 'email')->ignore($this->user)],
                'password' => ['string'],
                'role' => ['string', Rule::in(User::ROLES)],
            ],
            default => []
        };
    }
}
