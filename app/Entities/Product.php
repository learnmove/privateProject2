<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use App\Scopes\ProductScope;

class Product extends Model
{
    protected $table="products";
    public $timestamps=true;
    protected $fillable = ['school_id','visible','quantity','name','price','description','user_id','img'];
    //   protected static function boot()
    // {
    //     parent::boot();
    //     static::addGlobalScope(new ProductScope);
    // }
    public function scopeSearch($q,$keyword){
     return $q->where('name', 'like', '%'.$keyword.'%');
    }
    public function user(){
        return  $this->belongsTo(\App\Entities\User::class);
    }
    public function items(){
        return  $this->hasOne(\App\Entities\InvoiceItem::class,'product_id','id');
    }
    public function questions(){
        return $this->hasMany(\App\Entities\ProductQuestion::class,'product_id','id');
    }
    public function categories(){
        return $this->belongsToMany(Category::class,'product_category','product_id','category_id');
    }
    public function school(){
        return $this->belongsTo(School::class);
    }
}
