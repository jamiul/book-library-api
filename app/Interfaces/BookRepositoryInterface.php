<?php

namespace App\Interfaces;

interface BookRepositoryInterface
{
    public function getAllBooks(int $perPage = 10);

    public function createBook(array $data);

    public function getBookById(int $id);

    public function updateBook(int $id, array $data);

    public function deleteBook(int $id);

    public function searchByTitleOrAuthor(string $query, int $perPage = 10);
}