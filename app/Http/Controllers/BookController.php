<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\SearchBookRequest;
use App\Http\Requests\UpdateBookRequest;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $query = Book::query();

        if ($request->has("bookshelf_id")) {
            $query->where("bookshelf_id", $request->input("bookshelf_id"));
        }

        $books = $query->with("bookshelf")->get();
        return response()->json($books);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBookRequest $request): JsonResponse
    {
        $book = Book::create($request->validated());
        return response()->json($book, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book): JsonResponse
    {
         return response()->json($book->load("bookshelf"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBookRequest $request, Book $book)
    {
        $book->update($request->validated());

        return response()->json($book->load("bookshelf"));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book): JsonResponse
    {
        $book->delete();
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * Search for books by title or author.
     */
    public function search(SearchBookRequest $request): JsonResponse
    {
        $title = $request->query("title");
        $author = $request->query("author");

        if (!$title && !$author) {
            return response()->json(["message" => "Please provide a title or author to search for."], Response::HTTP_BAD_REQUEST);
        }

        $query = Book::query();

        if ($title) {
            $query->where("title", "like", "%" . $title . "%");
        }

        if ($author) {
            $query->where("author", "like", "%" . $author . "%");
        }

        $books = $query->with("bookshelf")->get();

        return response()->json($books);
    }
}
