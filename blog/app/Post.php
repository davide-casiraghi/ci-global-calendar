<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'title', 'body', 'author_id', 'slug', 'category_id', 'meta_description','meta_keywords', 'seo_title', 'image', 'status', 'featured', 'introimage_src', 'introimage_alt', 'before_content', 'after_content'
    ];
}
