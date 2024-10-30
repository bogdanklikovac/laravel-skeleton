<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TagTest extends TestCase
{
    use RefreshDatabase;

    public function test_should_retrun_201_when_creating_tag()
    {
        $tagData = $this->getTagArray();

        $response = $this->actingAs($this->user, 'sanctum')
            ->postJson(self::TAGS_ENDPOINT, $tagData);

        $response->assertStatus(201)
            ->assertJsonStructure($this->tagStructure());
    }

    public function test_should_return_422_when_creating_tag()
    {
        $tagData = $this->getTagArray();
        $tagData['name'] = '';

        $response = $this->actingAs($this->user, 'sanctum')
            ->postJson(self::TAGS_ENDPOINT, $tagData);

        $response->assertStatus(422);
    }

    public function test_should_return_401_when_creating_tag()
    {
        $tagData = $this->getTagArray();

        $response = $this
            ->postJson(self::TAGS_ENDPOINT, $tagData);

        $response->assertStatus(401);
    }

    public function test_should_return_200_when_getting_tag()
    {
        $response = $this
            ->actingAs($this->user, 'sanctum')
            ->getJson(self::TAGS_ENDPOINT . $this->tag->id);

        $response->assertStatus(200)
            ->assertJsonStructure($this->tagStructure());
    }

    public function test_should_return_404_when_getting_tag()
    {
        $nonExistingId = (int) $this->tag->id + 100;

        $response = $this
            ->actingAs($this->user, 'sanctum')
            ->getJson(self::TAGS_ENDPOINT . $nonExistingId);

        $response->assertStatus(404);
    }

    public function test_should_return_401_when_getting_tag()
    {
        $response = $this->getJson(self::TAGS_ENDPOINT . $this->tag->id);

        $response->assertStatus(401);
    }

    public function test_should_return_200_with_tag_collection()
    {
        $response = $this
            ->actingAs($this->user, 'sanctum')
            ->getJson(self::TAGS_ENDPOINT);

        $response->assertStatus(200)
            ->assertJsonStructure([$this->tagStructure()])
            ->assertJsonCount(10);
    }

    public function test_should_return_401_when_getting_tag_collection()
    {
        $response = $this
            ->getJson(self::TAGS_ENDPOINT);

        $response->assertStatus(401);
    }

    public function test_should_return_200_when_updating_tag()
    {
        $updatedName = ['name' => 'updated'];

        $response = $this
            ->actingAs($this->user, 'sanctum')
            ->putJson(self::TAGS_ENDPOINT . $this->tag->id, $updatedName);

        $response->assertStatus(200)
            ->assertJsonStructure($this->tagStructure());
    }

    public function test_should_return_422_when_updating_tag()
    {
        $updatedName = ['name' => ''];

        $response = $this
            ->actingAs($this->user, 'sanctum')
            ->putJson(self::TAGS_ENDPOINT . $this->tag->id, $updatedName);

        $response->assertStatus(422);
    }

    public function test_should_return_404_when_updating_tag()
    {
        $updatedName = ['name' => 'updated'];
        $nonExistingId = $this->tag->id + 100;

        $response = $this
            ->actingAs($this->user, 'sanctum')
            ->putJson(self::TAGS_ENDPOINT . $nonExistingId, $updatedName);

        $response->assertStatus(404);
    }

    public function test_should_return_401_when_updating_tag()
    {
        $updatedName = ['name' => 'updated'];

        $response = $this
            ->putJson(self::TAGS_ENDPOINT . $this->tag->id, $updatedName);

        $response->assertStatus(401);
    }

    public function test_should_return_204_when_deleting_tag()
    {
        $response = $this
            ->actingAs($this->user, 'sanctum')
            ->deleteJson(self::TAGS_ENDPOINT . $this->tag->id);

        $response->assertStatus(204);
    }

    public function test_should_return_404_when_deleting_tag()
    {
        $nonExistingId = $this->tag->id + 100;

        $response = $this
            ->actingAs($this->user, 'sanctum')
            ->deleteJson(self::TAGS_ENDPOINT . $nonExistingId);

        $response->assertStatus(404);
    }

    public function test_should_return_401_when_deleting_tag()
    {
        $response = $this
            ->deleteJson(self::TAGS_ENDPOINT . $this->tag->id);

        $response->assertStatus(401);
    }

    private function tagStructure(): array
    {
        return [
            'id',
            'name',
        ];
    }
}
