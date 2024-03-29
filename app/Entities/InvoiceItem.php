<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class InvoiceItem extends Model implements Transformable
{
    use TransformableTrait;
    protected $table="invoice_items";
    protected $fillable = ['buyer_id','user_name','product_name','invoice_id','product_id','quantity','seller_id','amount', 'order_status_id', 'pay_type_id', 'ship_type_id'];
    public function invoice(){
        return $this->belongsTo(Invoice::class);
    }
    // public function itemStatus(){
    //     return $this->belongsToMany(ItemStatus::class,'item_details','item_id','item_statuses_id')->withTimestamps()->orderBy('item_details.created_at','desc')->withPivot('requester_id');
    // }

    public function pay_type(){
        return $this->belongsTo(PayType::class);
    }
    public function order_status(){
        return $this->belongsTo(OrderStatus::class);
    }
    public function product(){
        return $this->belongsTo(Product::class);
    }
    public function rating(){
        return $this->hasOne(Rating::class,'item_id','id');
    }
    public function seller(){
        return $this->belongsTo(User::class,'seller_id','id');
    }
    public function buyer(){
        return $this->belongsTo(User::class,'buyer_id','id');
    }
    
    public function rating_comment(){
        return $this->hasOne(RatingComment::class,'item_id','id');
    }
}
