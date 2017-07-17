<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
class RatingComment extends Model implements Transformable
{
    use TransformableTrait;

    protected $fillable = ['feedback','user_id','item_id'];
    public function item(){
        return $this->belongsTo(InvoiceItem::class);
    }

}
