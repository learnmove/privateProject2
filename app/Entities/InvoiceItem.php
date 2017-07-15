<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class InvoiceItem extends Model implements Transformable
{
    use TransformableTrait;
    protected $table="invoice_items";
    protected $fillable = ['invoice_id','product_id','item_total_price','item_total_qty'];

}
