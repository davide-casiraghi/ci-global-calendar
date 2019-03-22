<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostTranslation extends Model
{
    /***************************************************************************/
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'post_translations';

    /***************************************************************************/

    public $timestamps = false;
    protected $fillable = ['title', 'body', 'slug', 'before_content', 'after_content', 'extra_field_trans_1', 'extra_field_trans_2'];
}
