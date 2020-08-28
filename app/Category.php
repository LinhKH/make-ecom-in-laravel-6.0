<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function categories(){
    	return $this->hasMany('App\Category','parent_id');
    }

    public function products(){
    	return $this->hasMany('App\Product','category_id');
    }
}
