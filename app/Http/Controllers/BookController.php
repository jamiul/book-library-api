<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\BookResource;
use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\SearchBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Interfaces\BookRepositoryInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Illuminate\Http\Resources\Json\ResourceCollection;

class BookController extends Controller
{
    private const DEFAULT_PER_PAGE = 10;

    public function __construct(
        private BookRepositoryInterface $bookRepository
    ) {}

    /**
     * Display a paginated list of books.
     */
    public function index(Request $request): ResourceCollection
    {
        $books = $this->bookRepository->getAllBooks(
            $this->getPerPage($request)
        );

        return BookResource::collection($books);
    }

    /**
     * Store a newly created book in storage.
     */
    public function store(StoreBookRequest $request): BookResource
    {
        $book = $this->bookRepository->createBook($request->validated());

        return new BookResource($book);
    }

    /**
     * Display the specified book.
     */
    public function show(int $id): BookResource
    {
        return new BookResource(
            $this->bookRepository->getBookById($id)->load("bookshelf")
        );
    }

    /**
     * Update the specified book in storage.
     */
    public function update(UpdateBookRequest $request, int $id): BookResource
    {
        $book = $this->bookRepository->updateBook($id, $request->validated());

        return new BookResource($book->load("bookshelf"));
    }

    /**
     * Remove the specified book from storage.
     */
    public function destroy(int $id): JsonResponse
    {
        $this->bookRepository->deleteBook($id);

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * Search for books by title or author.
     */
    public function search(SearchBookRequest $request): ResourceCollection
    {
        $query = $request->query("query");

        if (empty($query)) {
            return BookResource::collection([]);
        }

        $books = $this->bookRepository->searchByTitleOrAuthor(
            $query,
            $this->getPerPage($request)
        );

        return BookResource::collection($books);
    }

    /**
     * Get the per_page parameter from request or use default.
     */
    private function getPerPage(Request $request): int
    {
        return $request->query('per_page', self::DEFAULT_PER_PAGE);
    }
}