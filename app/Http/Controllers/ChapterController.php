<?php

namespace App\Http\Controllers;

use App\Models\Chapter;
use Illuminate\Http\Request;
use App\Http\Requests\StoreChapterRequest;
use App\Http\Requests\UpdateChapterRequest;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Http\Resources\ChapterResource;

class ChapterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $query = Chapter::query();

        // Optional filtering by book_id
        if ($request->has("book_id")) {
            $query->where("book_id", $request->input("book_id"));
        }

        $chapters = $query->with("book")->get();
        return response()->json(ChapterResource::collection($chapters));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreChapterRequest $request)
    {
        $chapter = Chapter::create($request->validated());

        return response()->json(new ChapterResource($chapter->load("book")), Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Chapter $chapter): JsonResponse
    {
         return response()->json(new ChapterResource($chapter->load("book")));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateChapterRequest $request, Chapter $chapter): JsonResponse
    {
        $chapter->update($request->validated());

        return response()->json(new ChapterResource($chapter->load("book")));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Chapter $chapter): JsonResponse
    {
        $chapter->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * Get the full content of a chapter by concatenating its pages.
     */
    public function getContent(Chapter $chapter): JsonResponse
    {
        $chapter->load(["pages" => function ($query) {
            $query->orderBy("page_number", "asc");
        }]);

        $fullContent = $chapter->pages->pluck("content")->implode("\n\n");

        return response()->json(["content" => $fullContent]);
    }
}
