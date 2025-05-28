<?php

namespace App\Http\Controllers;

use App\Models\Api\Bookshelf;
use App\Http\Requests\StoreBookshelfRequest;
use App\Http\Requests\UpdateBookshelfRequest;

class BookshelfController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBookshelfRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Bookshelf $bookshelf)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBookshelfRequest $request, Bookshelf $bookshelf)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Bookshelf $bookshelf)
    {
        //
    }
}
