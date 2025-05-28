<?php

namespace App\Interfaces;

interface BookshelfRepositoryInterface
{
    public function getAllBookshelves(int $perPage = 10);

    public function createBookshelf(array $data);

    public function getBookshelfById(int $id);

    public function updateBookshelf(int $id, array $data);

    public function deleteBookshelf(int $id);
}