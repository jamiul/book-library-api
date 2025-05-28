<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ChapterResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'book_id' => $this->book_id,
            'title' => $this->title,
            'chapter_number' => $this->chapter_number,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'book' => new BookResource($this->whenLoaded('book')),
        ];
    }
}
