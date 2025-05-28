<?php

namespace App\Interfaces;

interface ChapterRepositoryInterface
{
    public function getAllChapters(?int $bookId = null);

    public function createChapter(array $data);

    public function getChapterById(int $chapterId);

    public function updateChapter(int $chapterId, array $data);

    public function deleteChapter(int $chapterId);

    public function getChapterContent(int $chapterId);

    public function getPaginatedChapters(?int $bookId = null, int $perPage = 15);
}
