<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $chapterIds = \App\Models\Chapter::pluck('id')->all();
        \App\Models\Page::factory(100)->make()->each(function ($page) use ($chapterIds) {
            $page->chapter_id = fake()->randomElement($chapterIds);
            $page->save();
        });
    }
}
