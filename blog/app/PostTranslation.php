<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CountryTranslation extends Eloquent {

    public $timestamps = false;
    protected $fillable = ['title','body','slug','before_content','after_content'];

}
