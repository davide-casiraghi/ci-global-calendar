<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MenuItemTranslation extends Model {

    public $timestamps = false;
    protected $fillable = ['name', 'compact_name'];

}
