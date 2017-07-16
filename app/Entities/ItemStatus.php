<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class ItemStatus extends Model
{
    //
    protected $table="item_statuses";
    public function items(){
     return $this->belongsToMany(InvoiceItem::class,'item_details','id','item_statuses_id');
    }
}
