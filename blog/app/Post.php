<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use \Dimsav\Translatable\Translatable;

class Post extends Model
{
    public $translatedAttributes = ['title','body','slug','before_content','after_content'];
    protected $fillable = [
        'title', 'body', 'author_id', 'slug', 'category_id', 'meta_description','meta_keywords', 'seo_title', 'image', 'status', 'featured', 'introimage_src', 'introimage_alt', 'before_content', 'after_content'
    ];
}
