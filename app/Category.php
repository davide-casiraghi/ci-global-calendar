<?php

namespace App;

use Illuminate\Support\Facades\App;
use Illuminate\Database\Eloquent\Model;
use Dimsav\Translatable\Translatable;

use App\CategoryTranslation;

class Category extends Model
{
    /***************************************************************************/
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'categories';
    
    /***************************************************************************/
    
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
         $ret = Category::where('categories.id', $cat_id)->first();

         return $ret;
     }
     
     /***************************************************************************/
     /**
      * Return the post categories array
      * the collection is transferred to an array to symulate the pluck behaviour, 
      * and get the category name translated or the relative fallbacks.
      * (otherwise the pluck has empty names because doesn't fallback)
      *
      * @param  none
      * @return \Illuminate\Http\Response
      */
     
     public static function getCategoriesArray(){
                        
        //$ret = Category::pluck('name', 'id');
        $ret = array();
        
        $categories = Category::get();
        
        foreach ($categories as $key => $category) {
            $ret[$category->id] = $category->name;
        }                
                        
         return $ret;
     }
    
}
