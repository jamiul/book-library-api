<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bookshelfIds = \App\Models\Bookshelf::pluck('id')->all();
        \App\Models\Book::factory(20)->make()->each(function ($book) use ($bookshelfIds) {
            $book->bookshelf_id = fake()->randomElement($bookshelfIds);
            $book->save();
        });
    }
}
