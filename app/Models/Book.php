<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'isbn',
        'title',
        'release_date',
        'format',
        'pages',
        'publisher_id',
    ];

    public function publisher(): BelongsTo
    {
        return $this->belongsTo(Publisher::class)
            ->withDefault([
                'identifier' => 'Without ID',
                'first_name' => 'Not Found',
                'last_name' => 'Not Found',
            ]);
    }

    public function authors(): BelongsToMany
    {
        return $this->belongsToMany(Author::class, 'book_authors')
            ->using(BookAuthor::class);
    }
}
