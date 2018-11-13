<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventVenue extends Model
{
    protected $fillable = [
        'name', 'slug', 'description', 'image', 'website', 'facebook', 'created_by'
    ];
}
