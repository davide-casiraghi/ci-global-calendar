<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'title', 'description', 'organized_by', 'category_id', 'image', 'facebook_link', 'status'
    ];
}
