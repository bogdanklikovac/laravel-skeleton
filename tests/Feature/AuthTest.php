<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Auth\Passwords\PasswordBroker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    private const API_LOGIN = '/api/login';
    private const API_LOGOUT = '/api/logout';
    private const API_RESET_PASSWORD = '/api/reset-password';

    public function test_should_return_200_with_auth_login_response()
    {
        $userData = $this->getAuthUserArray();
        User::create($userData);

        $response = $this->postJson(self::API_LOGIN, [
                'email' => $userData['email'],
                'password' => $userData['password'],
            ]);

        $response->assertStatus(201)
            ->assertJsonStructure($this->authStructure());
    }

    public function test_should_return_422_on_auth_login_with_wrong_password()
    {
        $userData = $this->getAuthUserArray();

        $response = $this->postJson(self::API_LOGIN, [
            'email' => $userData['email'],
            'password' => 'wrongPassword',
        ]);

        $response->assertStatus(422);
    }

    public function test_should_return_200_and_logout_auth_user()
    {
        $this->applyAuthHeaders();

        $response = $this
            ->actingAs($this->user, 'sanctum')
            ->postJson(self::API_LOGOUT);

        $response->assertStatus(200);
    }

    public function test_should_return_401_when_auth_user_logout()
    {
        $response = $this
            ->postJson(self::API_LOGOUT);

        $response->assertStatus(401);
    }

    public function test_should_return_200_when_auth_update_user_password()
    {
        $token = app(PasswordBroker::class)->createToken($this->user);

        $response = $this
            ->putJson(self::API_RESET_PASSWORD . '/' . $token, [
                'email' => $this->user->email,
                'password' => 'new_password',
                'password_confirmation' => 'new_password',
            ]);

        $response->assertStatus(200);
    }

    public function test_should_return_422_on_auth_update_user_password()
    {
        $token = app(PasswordBroker::class)->createToken($this->user);

        $response = $this
            ->putJson(self::API_RESET_PASSWORD . '/' . $token, [
                'email' => $this->user->email,
                'password' => 'new_password',
                'password_confirmation' => 'non_matching_password',
            ]);

        $response->assertStatus(422);
    }

    public function test_should_send_mail_on_auth_forgot_password()
    {
        Notification::fake();

        $this->postJson(
            self::API_RESET_PASSWORD,
            ['email' => $this->user->email]
        );

        Notification::assertSentTo($this->user, ResetPassword::class);
    }

    public function test_should_return_200_on_auth_forgot_password()
    {
        Notification::fake();

        $response = $this->postJson(
            self::API_RESET_PASSWORD,
            ['email' => $this->user->email]
        );

        $response->assertStatus(200);
    }

    public function test_should_return_422_on_auth_forgot_password()
    {
        Notification::fake();

        $response = $this->postJson(
            self::API_RESET_PASSWORD,
            ['email' => 'nonExistingEmail@q.agency']
        );

        $response->assertStatus(422);
    }

    private function authStructure(): array
    {
        return [
            'token',
            'tokenType',
            'user' => [
                'id',
                'first_name',
                'last_name',
                'email',
            ],
        ];
    }
}
