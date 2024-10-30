<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Author extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'birthday',
        'biography',
        'place_of_birth',
    ];

    public function books(): BelongsToMany
    {
        return $this->belongsToMany(Book::class, 'book_authors')
            ->using(BookAuthor::class);
    }
}
