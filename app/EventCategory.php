<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventCategory extends Model
{
    /***************************************************************************/
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'event_categories';

    /***************************************************************************/

    use \Dimsav\Translatable\Translatable;

    public $translatedAttributes = ['name', 'slug'];
    protected $fillable = [];

    /***************************************************************************/

    /**
     * Return the category name.
     *
     * @param  int  $categoryId
     * @return string
     */
    public static function getCategoryName($categoryId)
    {
        $ret = self::find($categoryId)->name;

        return $ret;
    }
}
