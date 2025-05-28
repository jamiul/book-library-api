<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Api\Page>
 */
class PageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'chapter_id' => 1, // You can update this in seeder for relations
            'page_number' => $this->faker->numberBetween(1, 50),
            'content' => $this->faker->paragraphs(3, true),
        ];
    }
}
