<?php

namespace App;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

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
        'name', 'slug', 'description',
    ];

    /***************************************************************************/

    /**
     * Return the single category datas by cat id.
     *
     * @param  int $cat_id
     * @return \App\Category
     */
    public static function categorydata($cat_id)
    {
        $ret = self::where('categories.id', $cat_id)->first();

        return $ret;
    }

    /***************************************************************************/

    /**
     * Return the post categories array
     * the collection is transferred to an array to symulate the pluck behaviour,
     * and get the category name translated or the relative fallbacks.
     * (otherwise the pluck has empty names because doesn't fallback).
     *
     * @return array
     */
    public static function getCategoriesArray()
    {
        $ret = [];
        $categories = self::get();

        foreach ($categories as $key => $category) {
            $ret[$category->id] = $category->name;
        }

        return $ret;
    }
}
