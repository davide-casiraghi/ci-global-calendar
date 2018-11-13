<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Organizer extends Model
{
    protected $fillable = [
        'name', 'image', 'website', 'facebook', 'created_by', 'slug'
    ];
}
