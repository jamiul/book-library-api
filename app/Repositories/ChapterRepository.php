<?php

namespace App\Repositories;

use App\Models\Chapter;
use App\Interfaces\ChapterRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class ChapterRepository implements ChapterRepositoryInterface
{
    /**
     * Get all chapters with optional filtering by book ID.
     *
     * @param int|null $bookId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllChapters(?int $bookId = null): Collection
    {
        $query = Chapter::query();

        if ($bookId !== null) {
            $query->where('book_id', $bookId);
        }

        return $query->with('book')->get();
    }

    /**
     * Create a new chapter.
     *
     * @param array $data
     * @return \App\Models\Chapter
     */
    public function createChapter(array $data): Chapter
    {
        return Chapter::create($data);
    }

    /**
     * Get a chapter by its ID.
     *
     * @param int $chapterId
     * @return \App\Models\Chapter|null
     */
    public function getChapterById(int $chapterId): ?Chapter
    {
        return Chapter::with('book')->find($chapterId);
    }

    /**
     * Update an existing chapter.
     *
     * @param int $chapterId
     * @param array $data
     * @return \App\Models\Chapter
     */
    public function updateChapter(int $chapterId, array $data): Chapter
    {
        $chapter = Chapter::findOrFail($chapterId);
        $chapter->update($data);
        return $chapter;
    }

    /**
     * Delete a chapter by its ID.
     *
     * @param int $chapterId
     * @return bool
     */
    public function deleteChapter(int $chapterId): bool
    {
        $chapter = Chapter::findOrFail($chapterId);
        return $chapter->delete();
    }

    /**
     * Get the full content of a chapter by concatenating its pages.
     *
     * @param int $chapterId
     * @return string|null
     */
    public function getChapterContent(int $chapterId): ?string
    {
        $chapter = Chapter::with(["pages" => function ($query) {
            $query->orderBy("page_number", "asc");
        }])->find($chapterId);

        if (!$chapter) {
            return null;
        }

        return $chapter->pages->pluck("content")->implode("\n\n");
    }

    /**
     * Get paginated chapters with optional filtering by book ID.
     *
     * @param int|null $bookId
     * @param int $perPage
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getPaginatedChapters(?int $bookId = null, int $perPage = 15)
    {
        $query = Chapter::query();

        if ($bookId !== null) {
            $query->where('book_id', $bookId);
        }

        return $query->with('book')->paginate($perPage);
    }
}
