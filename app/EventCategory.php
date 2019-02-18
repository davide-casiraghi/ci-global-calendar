<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventCategory extends Model
{
    use \Dimsav\Translatable\Translatable;
    
    public $translatedAttributes = ['name','slug'];
    protected $fillable = [];
}
