<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
        public function products(){
        return $this->belongsToMany(Product::class,'product_category','category_id','product_id');
    }
}
