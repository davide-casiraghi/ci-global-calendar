<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventVenue extends Model
{
    protected $fillable = [
        'name', 'slug', 'description', 'image', 'website', 'facebook', 'continent_id', 'country_id', 'city', 'state_province', 'address', 'zip_code', 'created_by', 'created_at', 'updated_at'
    ];
}
