<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_should_create_user_and_return_201_and_created_user()
    {
        $response = $this->postJson(self::USERS_ENDPOINT, $this->getUserArray());

        $response->assertStatus(201)
            ->assertJsonStructure($this->userStructure());
    }

    public function test_should_return_422_when_trying_to_create_user()
    {
        $userData = $this->getUserArray();
        $userData['email'] = 'failEmail';

        $response = $this->postJson(self::USERS_ENDPOINT, $userData);

        $response->assertStatus(422);
    }

    public function test_should_return_200_with_single_user()
    {
        $response = $this
            ->actingAs($this->user, 'sanctum')
            ->getJson(self::USERS_ENDPOINT . $this->user->id);

        $response->assertStatus(200)
            ->assertJsonStructure($this->userStructure());
    }

    public function test_should_return_404_if_user_doesnt_exists()
    {
        $nonExistingId = (int) $this->user->id + 100;

        $response = $this
            ->actingAs($this->user, 'sanctum')
            ->getJson(self::USERS_ENDPOINT . $nonExistingId);

        $response->assertStatus(404);
    }

    public function test_should_return_401_on_get_user()
    {
        $response = $this
            ->getJson(self::USERS_ENDPOINT . $this->user->id);

        $response->assertStatus(401);
    }

    public function test_should_return_200_with_collection_of_users()
    {
        $response = $this
            ->actingAs($this->users->first(), 'sanctum')
            ->getJson(self::USERS_ENDPOINT);

        $response->assertStatus(200)
            ->assertJsonStructure([$this->userStructure()])
            ->assertJsonCount(10);
    }

    public function test_should_return_401_when_trying_to_get_user_collection()
    {
        $response = $this
            ->getJson(self::USERS_ENDPOINT);

        $response->assertStatus(401);
    }

    public function test_should_return_200_with_updated_user_using_all_fields()
    {
        $userData = $this->getUserArray();

        $response = $this
            ->actingAs($this->user, 'sanctum')
            ->putJson(self::USERS_ENDPOINT . $this->user->id, $userData);

        $response->assertStatus(200)
            ->assertJsonStructure($this->userStructure());
    }

    public function test_should_return_200_with_updated_user_using_one_field()
    {
        $singleFieldUserData = ['first_name' => 'Jhonny'];

        $response = $this
            ->actingAs($this->user, 'sanctum')
            ->putJson(self::USERS_ENDPOINT . $this->user->id, $singleFieldUserData);

        $response->assertStatus(200)
            ->assertJsonStructure($this->userStructure());
    }

    public function test_should_return_401_when_updating_user()
    {
        $userData = $this->getUserArray();

        $response = $this
            ->putJson(self::USERS_ENDPOINT . $this->user->id, $userData);

        $response->assertStatus(401);
    }

    public function test_should_return_404_when_updating_user()
    {
        $userData = $this->getUserArray();

        $response = $this
            ->actingAs($this->user, 'sanctum')
            ->putJson(self::USERS_ENDPOINT . ((int) $this->user->id + 100), $userData);

        $response->assertStatus(404);
    }

    public function test_should_return_422_when_updating_user()
    {
        $userData = $this->getUserArray();
        $userData['email'] = 'failValidation';

        $response = $this
            ->actingAs($this->user, 'sanctum')
            ->putJson(self::USERS_ENDPOINT . $this->user->id, $userData);

        $response->assertStatus(422);
    }

    public function test_should_return_204_when_deleting_user()
    {
        $response = $this
            ->actingAs($this->users->first(), 'sanctum')
            ->deleteJson(self::USERS_ENDPOINT . $this->users->last()->id);

        $response->assertStatus(204);
    }

    public function test_should_return_401_when_deleting_user()
    {
        $response = $this
            ->deleteJson(self::USERS_ENDPOINT . $this->users->last()->id);

        $response->assertStatus(401);
    }

    public function test_should_return_404_when_deleting_user()
    {
        $nonExistingId = (int) $this->users->last()->id + 100;

        $response = $this
            ->actingAs($this->users->first(), 'sanctum')
            ->deleteJson(self::USERS_ENDPOINT . $nonExistingId);

        $response->assertStatus(404);
    }

    public function test_should_return_200_and_add_tag_to_user()
    {
        $response = $this
            ->actingAs($this->user, 'sanctum')
            ->postJson(
                self::USERS_ENDPOINT . $this->user->id . '/tags/' . $this->tag->id
            );

        $response->assertStatus(200)
            ->assertJsonStructure($this->userTagStructure());
    }

    public function test_should_return_404_when_adding_tag_to_user()
    {
        $nonExistingId = $this->tag->id + 100;

        $response = $this
            ->actingAs($this->user, 'sanctum')
            ->postJson(
                self::USERS_ENDPOINT . $this->user->id . '/tags/' . $nonExistingId
            );

        $response->assertStatus(404);
    }

    public function test_should_return_401_when_adding_tag_to_user()
    {
        $response = $this
            ->postJson(
                self::USERS_ENDPOINT . $this->user->id . '/tags/' . $this->tag->id
            );

        $response->assertStatus(401);
    }

    public function test_should_return_200_when_removing_tag_from_user()
    {
        $this->user->tags()->attach($this->tag);

        $response = $this
            ->actingAs($this->user, 'sanctum')
            ->deleteJson(self::USERS_ENDPOINT . $this->user->id . '/tags/' . $this->tag->id);

        $response->assertStatus(200);
    }

    public function test_should_return_404_when_removing_tag_from_user()
    {
        $this->user->tags()->attach($this->tag);
        $nonExistingId = $this->tag->id + 100;

        $response = $this
            ->actingAs($this->user, 'sanctum')
            ->deleteJson(self::USERS_ENDPOINT . $this->user->id . '/tags/' . $nonExistingId);

        $response->assertStatus(404);
    }

    public function test_should_return_401_when_removing_tag_from_user()
    {
        $this->user->tags()->attach($this->tag);

        $response = $this
            ->deleteJson(self::USERS_ENDPOINT . $this->user->id . '/tags/' . $this->tag->id);

        $response->assertStatus(401);
    }

    private function userStructure(): array
    {
        return [
            'id',
            'first_name',
            'last_name',
            'email',
        ];
    }

    private function userTagStructure(): array
    {
        return [
            'id',
            'first_name',
            'last_name',
            'email',
            'tags' => [
                [
                    'id',
                    'name',
                ],
            ],
        ];
    }
}
