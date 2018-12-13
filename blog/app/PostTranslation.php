<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostTranslation extends Model {

    public $timestamps = false;
    protected $fillable = ['title','body','slug','before_content','after_content'];

}
