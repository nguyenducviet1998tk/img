<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Img extends Model
{
    //
    protected $table = "images";

    public function user(){
        return $this->belongsTo('App\User','user_id');
    }
}
