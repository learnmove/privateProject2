<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class PrivateMessage extends Model
{
    //
    protected $fillable=
    [ 'sender_id',
           'receiver_id',
         'message','read'];

}
