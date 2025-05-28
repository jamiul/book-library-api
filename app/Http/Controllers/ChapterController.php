<?php

namespace App\Http\Controllers;

use App\Models\Chapter;
use Illuminate\Http\Request;
use App\Http\Requests\StoreChapterRequest;
use App\Http\Requests\UpdateChapterRequest;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Resources\ChapterResource;
use App\Interfaces\ChapterRepositoryInterface;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\JsonResponse;

class ChapterController extends Controller
{
    public function __construct(
        private readonly ChapterRepositoryInterface $chapterRepository
    ) {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): ResourceCollection
    {
        $perPage = $request->input('per_page', 10);

        $chapters = $this->chapterRepository->getPaginatedChapters(
            $request->input('book_id'),
            $perPage
        );

        return ChapterResource::collection($chapters);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreChapterRequest $request): JsonResponse
    {
        $chapter = $this->chapterRepository->createChapter($request->validated());

        return response()->json(
            new ChapterResource($chapter->load('book')),
            Response::HTTP_CREATED
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Chapter $chapter): JsonResponse
    {
        return response()->json(
            new ChapterResource($chapter->load('book'))
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateChapterRequest $request, Chapter $chapter): JsonResponse
    {
        $this->chapterRepository->updateChapter($chapter->id, $request->validated());

        return response()->json(
            new ChapterResource(
                $this->chapterRepository->getChapterById($chapter->id)->load('book')
            )
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Chapter $chapter): JsonResponse
    {
        $this->chapterRepository->deleteChapter($chapter->id);

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * Get the full content of a chapter by concatenating its pages.
     */
    public function getContent(Chapter $chapter): JsonResponse
    {
        return response()->json([
            'content' => $this->chapterRepository->getChapterContent($chapter->id)
        ]);
    }
}
