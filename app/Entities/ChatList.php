<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class ChatList extends Model
{
    //
    protected $table="chat_lists";
    protected $fillable=['user_id','chat_id'];

}
