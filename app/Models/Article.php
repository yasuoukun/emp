<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = ['title', 'content', 'author_name', 'images', 'is_published'];

    protected $casts = [
        'images' => 'array',
        'is_published' => 'boolean',
    ];
}
