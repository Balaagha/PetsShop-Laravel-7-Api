<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
//    protected $table = 'products';
//    protected $fillable = ['name','slug','price','description'];
    protected $guarded = [];
//    protected $hidden = ['slug'];
    public function categories(){
        return $this->belongsToMany('App\Category','product_categories');
    }
}
