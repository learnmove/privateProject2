<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Rating extends Model implements Transformable
{
    use TransformableTrait;

    protected $fillable = ['level','user_id','item_id'];
    public function item(){
        return $this->belongsTo(InvoiceItem::class);
    }
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }

}
