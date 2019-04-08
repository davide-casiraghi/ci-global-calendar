<?php

namespace App;

use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;

class Continent extends Model
{
    /***************************************************************************/
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'continents';

    /***************************************************************************/

    protected $fillable = [
        'name', 'code',
    ];

    /***************************************************************************/

    /**
     * Return all the continents ordered by name.
     *
     * @return \App\Continent
     */
    public static function getContinents()
    {
        $minutes = 15;
        $ret = Cache::remember('continents_list', $minutes, function () {
            return Continent::orderBy('name')->pluck('name', 'id');
        });

        return $ret;
    }
}
