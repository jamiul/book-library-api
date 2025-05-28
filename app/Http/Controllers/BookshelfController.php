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
    public function __construct(
        private readonly BookshelfRepositoryInterface $bookshelfRepository
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bookshelves = $this->bookshelfRepository->getAllBookshelves(10);

        return BookshelfResource::collection($bookshelves);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBookshelfRequest $request): JsonResponse
    {
        $bookshelf = $this->bookshelfRepository->createBookshelf($request->validated());

        return $this->successResponse(
            new BookshelfResource($bookshelf),
            Response::HTTP_CREATED
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Bookshelf $bookshelf): JsonResponse
    {
        return $this->successResponse(new BookshelfResource($bookshelf));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBookshelfRequest $request, Bookshelf $bookshelf): JsonResponse
    {
        $updatedBookshelf = $this->bookshelfRepository->updateBookshelf(
            $bookshelf->id,
            $request->validated()
        );

        return $this->successResponse(new BookshelfResource($updatedBookshelf));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Bookshelf $bookshelf): JsonResponse
    {
        $this->bookshelfRepository->deleteBookshelf($bookshelf->id);

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * Create a standardized success response.
     */
    private function successResponse($data, int $statusCode = Response::HTTP_OK): JsonResponse
    {
        return response()->json($data, $statusCode);
    }
}