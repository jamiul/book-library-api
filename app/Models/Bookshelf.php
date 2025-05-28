<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bookshelf extends Model
{
    /** @use HasFactory<\Database\Factories\Api\BookshelfFactory> */
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'location',
    ];

    /**
     * Get the books for the bookshelf.
     */
    public function books(): HasMany
    {
        return $this->hasMany(Book::class);
    }
}
