<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Organizer extends Model
{
    protected $fillable = [
        'name', 'description', 'website', 'created_by', 'slug', 'email', 'phone'
    ];
}
