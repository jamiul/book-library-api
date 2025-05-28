<?php

namespace App\Http\Controllers;

use App\Models\Bookshelf;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\StoreBookshelfRequest;
use App\Http\Requests\UpdateBookshelfRequest;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Resources\BookshelfResource;

class BookshelfController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $bookshelves = Bookshelf::paginate(10);
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
        $bookshelf = Bookshelf::create($request->validated());
        return response()->json(new BookshelfResource($bookshelf), Response::HTTP_CREATED);
    }


    /**
     * Display the specified resource.
     */
    public function show(Bookshelf $bookshelf): JsonResponse
    {
        return response()->json(new BookshelfResource($bookshelf));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBookshelfRequest $request, Bookshelf $bookshelf): JsonResponse
    {
        $bookshelf->update($request->validated());
        return response()->json(new BookshelfResource($bookshelf), Response::HTTP_OK);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Bookshelf $bookshelf): JsonResponse
    {
        $bookshelf->delete();
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
