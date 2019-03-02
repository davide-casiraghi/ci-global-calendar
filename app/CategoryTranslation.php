<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoryTranslation extends Model
{
    /***************************************************************************/
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'category_translations';

    /***************************************************************************/

    public $timestamps = false;
    protected $fillable = ['name', 'compact_name'];
}
