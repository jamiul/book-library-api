<?php

namespace App\Repositories;

use App\Interfaces\PageRepositoryInterface;
use App\Models\Page;
use Illuminate\Database\Eloquent\Collection;

class PageRepository implements PageRepositoryInterface
{
    public function getAllPagesByChapterId(int $chapterId): Collection
    {
        return Page::where("chapter_id", $chapterId)
            ->with("chapter")
            ->orderBy("page_number", "asc")
            ->get();
    }

    public function createPage(array $data): Page
    {
        return Page::create($data);
    }

    public function getPageById(int $pageId): ?Page
    {
        return Page::with("chapter")->find($pageId);
    }

    public function updatePage(int $pageId, array $data): Page
    {
        $page = Page::findOrFail($pageId);
        $page->update($data);
        return $page->load("chapter");
    }

    public function deletePage(int $pageId): bool
    {
        $page = Page::findOrFail($pageId);
        return $page->delete();
    }

    public function pageExistsForChapter(int $chapterId, int $pageNumber, ?int $excludePageId = null): bool
    {
        $query = Page::where("chapter_id", $chapterId)
            ->where("page_number", $pageNumber);

        if ($excludePageId !== null) {
            $query->where("id", "!=", $excludePageId);
        }

        return $query->exists();
    }
}
