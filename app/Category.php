<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function products(){
        return $this->belongsToMany('App\Products','product_categories');
    }
    public function childcategories(){
        return $this->hasMany('App\ChildCategory');
    }
}
