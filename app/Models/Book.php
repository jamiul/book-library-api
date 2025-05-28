<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Book extends Model
{
    /** @use HasFactory<\Database\Factories\Api\BookFactory> */
    use HasFactory;

     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'bookshelf_id',
        'title',
        'author',
        'published_year',
    ];

    /**
     * Get the bookshelf that owns the book.
     */
    public function bookshelf(): BelongsTo
    {
        return $this->belongsTo(Bookshelf::class);
    }

    /**
     * Get the chapters for the book.
     */
    public function chapters(): HasMany
    {
        return $this->hasMany(Chapter::class);
    }
}
