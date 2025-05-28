<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;
use App\Http\Resources\PageResource;
use App\Http\Requests\StorePageRequest;
use App\Http\Requests\UpdatePageRequest;
use Symfony\Component\HttpFoundation\Response;
use App\Interfaces\PageRepositoryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class PageController extends Controller
{

    public function __construct(
        private readonly PageRepositoryInterface $pageRepository
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $chapterId = $request->input("chapter_id");
        $pages = $this->pageRepository->getAllPagesByChapterId($chapterId);

        return response()->json(PageResource::collection($pages));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePageRequest $request): JsonResponse
    {
        // Check for duplicate page number within the same chapter is handled in the repository
        $page = $this->pageRepository->createPage($request->validated());

        return (new PageResource($page->load("chapter")))->response()->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Page $page)
    {
        // The route model binding already fetches the page, so we just return it
        return new PageResource($page->load("chapter"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePageRequest $request, Page $page): JsonResponse
    {
        // Check for duplicate page number if it's being changed is handled in the repository
        $updatedPage = $this->pageRepository->updatePage($page->id, $request->validated());

        return response()->json(new PageResource($updatedPage->load("chapter")));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Page $page): JsonResponse
    {
        $this->pageRepository->deletePage($page->id);
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
