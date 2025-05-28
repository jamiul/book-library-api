<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;
use App\Http\Resources\PageResource;
use App\Http\Requests\StorePageRequest;
use App\Http\Requests\UpdatePageRequest;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $query = Page::query();

        // Optional filtering by chapter_id
        if ($request->has("chapter_id")) {
            $query->where("chapter_id", $request->input("chapter_id"));
        }

        $pages = $query->with("chapter")->orderBy("page_number", "asc")->get();

        return response()->json(PageResource::collection($pages));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePageRequest $request): JsonResponse
    {
        // Check for duplicate page number within the same chapter
        $exists = Page::where("chapter_id", $request->input("chapter_id"))
            ->where("page_number", $request->input("page_number"))
            ->exists();

        if ($exists) {
            return response()->json(["page_number" => ["The page number already exists for this chapter."]], 422);
        }

        $page = Page::create($request->validated());

        return (new PageResource($page->load("chapter")))->response()->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Page $page)
    {
        return new PageResource($page->load("chapter"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePageRequest $request, Page $page): JsonResponse
    {
        // Check for duplicate page number if it's being changed
        if ($request->has("page_number") && $request->input("page_number") !== $page->page_number) {
            $chapterId = $request->input("chapter_id", $page->chapter_id);
            $exists = Page::where("chapter_id", $chapterId)
                ->where("page_number", $request->input("page_number"))
                ->where("id", "!=", $page->id) // Exclude the current page
                ->exists();

            if ($exists) {
                return response()->json(["page_number" => ["The page number already exists for this chapter."]], 422);
            }
        }

        $page->update($request->validated());

        return response()->json(new PageResource($page->load("chapter")));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Page $page): JsonResponse
    {
        $page->delete();
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
