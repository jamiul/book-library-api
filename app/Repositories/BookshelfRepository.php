<?php

namespace App\Repositories;

use App\Models\Bookshelf;
use App\Interfaces\BookshelfRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class BookshelfRepository implements BookshelfRepositoryInterface
{
    /**
     * Bookshelf model instance.
     *
     * @var Bookshelf
     */
    protected $model;

    /**
     * BookshelfRepository constructor.
     *
     * @param Bookshelf $bookshelf
     */
    public function __construct(Bookshelf $bookshelf)
    {
        $this->model = $bookshelf;
    }

    /**
     * Get all bookshelves with pagination.
     *
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getAllBookshelves(int $perPage = 10): LengthAwarePaginator
    {
        return $this->model->newQuery()->paginate($perPage);
    }

    /**
     * Create a new bookshelf.
     *
     * @param array $data
     * @return Bookshelf
     */
    public function createBookshelf(array $data): Bookshelf
    {
        return $this->model->create($data);
    }

    /**
     * Get a specific bookshelf by ID.
     *
     * @param int $id
     * @return Bookshelf
     * @throws ModelNotFoundException
     */
    public function getBookshelfById(int $id): Bookshelf
    {
        return $this->model->findOrFail($id);
    }

    /**
     * Update an existing bookshelf.
     *
     * @param int $id
     * @param array $data
     * @return Bookshelf
     * @throws ModelNotFoundException
     */
    public function updateBookshelf(int $id, array $data): Bookshelf
    {
        $bookshelf = $this->model->findOrFail($id);
        $bookshelf->update($data);

        return $bookshelf->fresh();
    }

    /**
     * Delete a bookshelf by ID.
     *
     * @param int $id
     * @return Bookshelf
     * @throws ModelNotFoundException
     */
    public function deleteBookshelf(int $id): Bookshelf
    {
        $bookshelf = $this->model->findOrFail($id);
        $bookshelf->delete();

        return $bookshelf;
    }
}