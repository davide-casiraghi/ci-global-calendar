<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventCategoryTranslation extends Model
{
    /***************************************************************************/
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'event_category_translations';

    /***************************************************************************/

    public $timestamps = false;
    protected $fillable = ['name', 'slug'];
}
