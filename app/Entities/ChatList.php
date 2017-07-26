<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class ChatList extends Model
{
    //
    protected $table="chat_lists";
    protected $fillable=['user_id','chat_id'];
 
     public function getCreatedAtAttribute($date)
    {
        return \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $date)->diffForHumans();
    }
}
