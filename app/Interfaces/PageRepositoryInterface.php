<?php

namespace App\Interfaces;

interface PageRepositoryInterface
{
    public function getAllPagesByChapterId(int $chapterId);

    public function createPage(array $data);

    public function getPageById(int $pageId);

    public function updatePage(int $pageId, array $data);

    public function deletePage(int $pageId);
}