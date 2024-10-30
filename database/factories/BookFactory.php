<?php

namespace Database\Factories;

use App\Models\Publisher;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'isbn' => $this->faker->unique()->isbn13(),
            'title' => ucfirst($this->faker->words(5, true)),
            'release_date' => $this->faker->date(),
            'format' => 'PDF',
            'pages' => $this->faker->numberBetween(50, 400),
            'publisher_id' => Publisher::inRandomOrder()->first()->id,
        ];
    }
}
