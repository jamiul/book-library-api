<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ChapterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bookIds = \App\Models\Book::pluck('id')->all();
        \App\Models\Chapter::factory(40)->make()->each(function ($chapter) use ($bookIds) {
            $chapter->book_id = fake()->randomElement($bookIds);
            $chapter->save();
        });
    }
}
