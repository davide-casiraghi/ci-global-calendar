<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Organizer extends Model
{
    /***************************************************************************/
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'organizers';

    /***************************************************************************/

    protected $fillable = [
        'name', 'description', 'website', 'created_by', 'slug', 'email', 'phone',
    ];
}
