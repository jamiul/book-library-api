<?php

namespace App\Http\Controllers;

use App\Models\Bookshelf;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\StoreBookshelfRequest;
use App\Http\Requests\UpdateBookshelfRequest;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Resources\BookshelfResource;
use App\Interfaces\BookshelfRepositoryInterface;

class BookshelfController extends Controller
{
    private BookshelfRepositoryInterface $bookshelfRepository;

    public function __construct(BookshelfRepositoryInterface $bookshelfRepository)
    {
        $this->bookshelfRepository = $bookshelfRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $bookshelves = $this->bookshelfRepository->getAllBookshelves(10);

        return response()->json([
            'data' => BookshelfResource::collection($bookshelves->items()),
            'meta' => [
                'current_page' => $bookshelves->currentPage(),
                'last_page' => $bookshelves->lastPage(),
                'per_page' => $bookshelves->perPage(),
                'total' => $bookshelves->total(),
            ],
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBookshelfRequest $request): JsonResponse
    {
        $bookshelf = $this->bookshelfRepository->createBookshelf($request->validated());

        return response()->json(new BookshelfResource($bookshelf), Response::HTTP_CREATED);
    }


    /**
     * Display the specified resource.
     */
    public function show(Bookshelf $bookshelf): JsonResponse
    {
        $bookshelf = $this->bookshelfRepository->getBookshelfById($bookshelf->id);

        return response()->json(new BookshelfResource($bookshelf));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBookshelfRequest $request, Bookshelf $bookshelf): JsonResponse
    {
        $bookshelf = $this->bookshelfRepository->updateBookshelf($bookshelf->id, $request->validated());

        return response()->json(new BookshelfResource($bookshelf), Response::HTTP_OK);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Bookshelf $bookshelf): JsonResponse
    {
        $this->bookshelfRepository->deleteBookshelf($bookshelf->id);

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
