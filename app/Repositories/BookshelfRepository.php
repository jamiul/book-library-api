<?php

namespace App\Repositories;

use App\Models\Bookshelf;
use App\Interfaces\BookshelfRepositoryInterface;

class BookshelfRepository implements BookshelfRepositoryInterface
{
    /**
     * Get all bookshelves with pagination.
     *
     * @param int $perPage
     * @return mixed
     */
    public function getAllBookshelves(int $perPage = 10): object
    {
        return Bookshelf::paginate($perPage);
    }

    /**
     * Create a new bookshelf.
     *
     * @param array $data
     * @return mixed
     */
    public function createBookshelf(array $data): Bookshelf
    {
        return Bookshelf::create($data);
    }

    /**
     * Get a specific bookshelf by ID.
     *
     * @param int $id
     * @return mixed
     */
    public function getBookshelfById(int $id): Bookshelf
    {
        return Bookshelf::findOrFail($id);
    }

    /**
     * Update an existing bookshelf.
     *
     * @param int $id
     * @param array $data
     * @return mixed
     */
    public function updateBookshelf(int $id, array $data): Bookshelf
    {
        $bookshelf = Bookshelf::findOrFail($id);
        $bookshelf->update($data);
        return $bookshelf;
    }

    /**
     * Delete a bookshelf by ID.
     *
     * @param int $id
     * @return mixed
     */
    public function deleteBookshelf(int $id): Bookshelf
    {
        $bookshelf = Bookshelf::findOrFail($id);
        $bookshelf->delete();
        return $bookshelf;
    }
}
