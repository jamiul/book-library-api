<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Chapter extends Model
{
    /** @use HasFactory<\Database\Factories\Api\ChapterFactory> */
    use HasFactory, SoftDeletes;

     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'book_id',
        'title',
        'chapter_number',
    ];

    /**
     * Get the book that owns the chapter.
     */
    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

    /**
     * Get the pages for the chapter.
     */
    public function pages(): HasMany
    {
        return $this->hasMany(Page::class);
    }
}
