<?php

namespace App\Repositories;

use App\Interfaces\BookRepositoryInterface;
use App\Models\Book;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class BookRepository implements BookRepositoryInterface
{
    private const DEFAULT_PER_PAGE = 10;

    /**
     * Get all books with pagination.
     */
    public function getAllBooks(int $perPage = self::DEFAULT_PER_PAGE): LengthAwarePaginator
    {
        return Book::query()->paginate($perPage);
    }

    /**
     * Create a new book.
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function createBook(array $data): Book
    {
        return Book::create($data);
    }

    /**
     * Get a specific book by ID.
     *
     * @throws ModelNotFoundException
     */
    public function getBookById(int $id): Book
    {
        return Book::findOrFail($id);
    }

    /**
     * Update an existing book.
     *
     * @throws ModelNotFoundException
     */
    public function updateBook(int $id, array $data): Book
    {
        $book = $this->getBookById($id);
        $book->update($data);
        return $book->fresh();
    }

    /**
     * Delete a book by ID.
     *
     * @throws ModelNotFoundException
     */
    public function deleteBook(int $id): Book
    {
        $book = $this->getBookById($id);
        $book->delete();
        return $book;
    }

    /**
     * Search books by title or author with pagination.
     */
    public function searchByTitleOrAuthor(string $query, int $perPage = self::DEFAULT_PER_PAGE): LengthAwarePaginator
    {
        return Book::query()
            ->where(function ($q) use ($query) {
                $q->where('title', 'LIKE', "%{$query}%")
                  ->orWhere('author', 'LIKE', "%{$query}%");
            })
            ->paginate($perPage);
    }
}