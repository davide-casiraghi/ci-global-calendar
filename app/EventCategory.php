<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventCategory extends Model
{
    use \Dimsav\Translatable\Translatable;
    
    public $translatedAttributes = ['name','slug'];
    protected $fillable = [];
    
    /***************************************************************************/
    /**
     * Return the category name
     *
     * @param  int  category id
     * @return string the category name
     */
    public static function getCategoryName($categoryId){
        $ret = EventCategory::find($categoryId)->name;
                
        return $ret;
    }
}
