<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Api\Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'bookshelf_id' => 1, // You can update this in seeder for relations
            'title' => $this->faker->sentence(3),
            'author' => $this->faker->name,
            'published_year' => $this->faker->year,
        ];
    }
}
