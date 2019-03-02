<?php

namespace App;

use Illuminate\Support\Facades\App;
use Illuminate\Database\Eloquent\Model;
use Dimsav\Translatable\Translatable;

class Post extends Model
{
    /***************************************************************************/
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'posts';
    
    /***************************************************************************/
    
    use Translatable;

    public $translatedAttributes = ['title','body','slug','before_content','after_content','extra_field_trans_1','extra_field_trans_2'];
    protected $fillable = [
        'title', 'body', 'author_id', 'slug', 'category_id', 'meta_description','meta_keywords', 'seo_title', 'image', 'status', 'featured', 'introimage_src', 'introimage_alt', 'before_content', 'after_content','extra_field_1','extra_field_2','extra_field_3','extra_field_trans_1','extra_field_trans_2'
    ];
    
    /***************************************************************************/
    /**
     * Return all the posts by category id in the language specified
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
     public static function postsByCategory($cat_id){
         $ret = Post::
               where('category_id', $cat_id)
               ->get();

         return $ret;
     }
    
}
