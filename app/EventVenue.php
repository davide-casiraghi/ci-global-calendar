<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventVenue extends Model
{
    /***************************************************************************/
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'event_venues';
    
    /***************************************************************************/
    
    protected $fillable = [
        'name', 'slug', 'continent_id', 'country_id', 'city', 'state_province', 'address', 'zip_code', 'description', 'website', 'created_by', 'created_at', 'updated_at'
    ];
    
    /***************************************************************************/
    /**
     * Return the venue name
     *
     * @param  int  venue id
     * @return string the venue name
     */
    public static function getVenueName($venueId){
        $ret = EventVenue::find($venueId)->name;
            
        return $ret;
    }
}
