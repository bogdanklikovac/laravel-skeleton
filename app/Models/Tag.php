<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    protected $hidden = ['pivot'];

    public $timestamps = false;

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, UserTags::class);
    }
}
