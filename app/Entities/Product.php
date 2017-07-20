<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use App\Scopes\ProductScope;

class Product extends Model implements Transformable
{
    use TransformableTrait;
     protected $table="products";
     public $timestamps=true;
    protected $fillable = ['school_id','visible','qty','name','price','description','user_id','img'];
    //   protected static function boot()
    // {
    //     parent::boot();
    //     static::addGlobalScope(new ProductScope);
    // }
    public function user(){
        return  $this->belongsTo(\App\Entities\User::class);
    }
    public function items(){
        return  $this->hasOne(\App\Entities\InvoiceItem::class,'product_id','id');
    }
    public function questions(){
        return $this->hasMany(\App\Entities\ProductQuestion::class,'product_id','id');
    }

}
