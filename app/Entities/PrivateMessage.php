<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class PrivateMessage extends Model
{
    //
    protected $fillable=
    [ 'sender_id',
           'receiver_id',
         'message','read','channel_id'];
          public function getCreatedAtAttribute($date)
    {
        return \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $date)->diffForHumans();
    }
         public function receiver(){
             return $this->belongsTo(User::class,'receiver_id','id');
         }
                 public function sender(){
             return $this->belongsTo(User::class,'sender_id','id');
         }
}
