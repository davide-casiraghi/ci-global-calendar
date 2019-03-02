<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MenuItemTranslation extends Model {
    
    /***************************************************************************/
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'menu_item_translations';
    
    /***************************************************************************/
    
    public $timestamps = false;
    protected $fillable = ['name', 'description', 'slug'];

}
