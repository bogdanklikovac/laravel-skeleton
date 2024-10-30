<?php

namespace Database\Seeders;

use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    public function run()
    {
        Tag::factory(20)->create()->each(function ($tag) {
            $tag->users()->save(User::inRandomOrder()->first())->make();
        });
    }
}
