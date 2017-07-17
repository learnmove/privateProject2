<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class InvoiceItem extends Model implements Transformable
{
    use TransformableTrait;
    protected $table="invoice_items";
    protected $fillable = ['user_name','product_name','invoice_id','product_id','item_total_price','item_total_qty','seller_id'];
    public function invoice(){
        return $this->belongsTo(Invoice::class);
    }
    public function itemStatus(){
        return $this->belongsToMany(ItemStatus::class,'item_details','item_id','item_statuses_id')->withTimestamps()->orderBy('item_details.created_at','desc')->withPivot('requester_id');
    }
    public function product(){
        return $this->belongsTo(Product::class);
    }
    public function rating(){
        return $this->hasOne(Rating::class,'item_id','id');
    }
    public function rating_comment(){
        return $this->hasOne(RatingComment::class,'item_id','id');
    }
}
