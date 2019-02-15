<?php

namespace App;

use Illuminate\Support\Facades\App;
use Illuminate\Database\Eloquent\Model;
use Dimsav\Translatable\Translatable;

use App\CategoryTranslation;

class Category extends Model
{
    use Translatable;
    
    public $translatedAttributes = ['name', 'description', 'slug'];
    
    /* They probably can be removed all since are  translated Attributes so it would become [] */
    protected $fillable = [
        'name', 'slug', 'description'
    ];
    
    /***************************************************************************/
    /**
     * Return the single category datas by cat id
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
     public static function categorydata($cat_id){
         $ret = Category::
                    join('category_translations', 'categories.id', '=', 'category_translations.category_id')
                    ->where('locale', App::getLocale())
                    ->where('categories.id', $cat_id)->first();

         return $ret;
     }
    
}
