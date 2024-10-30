<?php

namespace App\Http\Requests\Auth;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Password;

class ResetPasswordRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'confirmed'],
            'token' => ['required', 'string'],
        ];
    }

    public function changePasswordStatus(): mixed
    {
        return Password::reset($this->all(), static function (User $user, string $password) {
            $user->password = $password;
            $user->save();
        });
    }

    public function all($keys = null): array
    {
        $data = parent::all($keys);
        $data['token'] = $this->route('token');

        return $data;
    }
}
