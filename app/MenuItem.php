<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    protected $fillable = [
        'name', 'compact_name', 'parent_item', 'link', 'font_awesome_class'
    ];
}
