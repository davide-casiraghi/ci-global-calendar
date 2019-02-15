<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Dimsav\Translatable\Translatable;

use App\CategoryTranslation;

class Category extends Model
{
    use Translatable;
    
    public $translatedAttributes = ['name', 'description', 'slug'];
    
    /* They probably can be removed all since are  translated Attributes so it would become [] */
    protected $fillable = [
        'name', 'slug', 'description'
    ];
}
