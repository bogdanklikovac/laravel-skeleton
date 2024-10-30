<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Book;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    public function run()
    {
        Book::factory(50)->create()->each(function ($book) {
            $book->authors()->save(Author::inRandomOrder()->first())->make();
        });
    }
}
