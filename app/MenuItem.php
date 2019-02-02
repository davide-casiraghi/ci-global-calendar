<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    protected $fillable = [
        'name', 'compact_name', 'parent_item_id', 'url', 'font_awesome_class', 'lang_string','route','type','menu_id','order'
    ];
}
