<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventCategoryTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = ['name','slug'];
}
