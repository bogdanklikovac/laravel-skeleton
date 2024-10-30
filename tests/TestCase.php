<?php

namespace Tests;

use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public const USERS_ENDPOINT = 'api/v1/users/';
    public const TAGS_ENDPOINT = 'api/v1/tags/';

    protected User $user;
    protected Collection $users;
    protected Tag $tag;
    protected Collection $tags;

    public function setUp(): void
    {
        parent::setUp();

        $this->users = $this->users(10);
        $this->user = $this->users->first();

        $this->tags = $this->tags(10);
        $this->tag = $this->tags->first();
    }

    protected function users(?int $number = null)
    {
        return User::factory($number)->create();
    }

    protected function tags(?int $number = null)
    {
        return Tag::factory($number)->create();
    }

    protected function getBearerToken(): string
    {
        return $this->user->createToken('api_token')->plainTextToken;
    }

    protected function applyAuthHeaders()
    {
        $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->getBearerToken(),
            'Accept' => 'application/json',
        ]);
    }

    protected function getUserArray(): array
    {
        return [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john.doe@q.agency',
            'password' => 'password',
        ];
    }

    protected function getAuthUserArray(): array
    {
        return [
            'first_name' => 'John',
            'last_name' => 'Auth',
            'email' => 'john.auth@q.agency',
            'password' => 'password',
        ];
    }

    protected function getTagArray(): array
    {
        return ['name' => 'Author'];
    }
}
