<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Product extends Model implements Transformable
{
    use TransformableTrait;
     protected $table="products";
     public $timestamps=true;
    protected $fillable = ['qty','name','price','description','user_id','img'];
    public function user(){
        return  $this->belongsTo(\App\Entities\User::class);
    }
}
