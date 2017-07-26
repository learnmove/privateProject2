<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'school_id',
        'name', 
        'email'
        , 'password'
        ,'account',
        'avatar'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
      public function receivesBroadcastNotificationsOn()
    {
        return 'App.User.'.$this->id;
    }
    public function products(){
        return $this->hasMany(\App\Entities\Product::class);
    }
    public function getCreatedAtAttribute($date)
    {
        return \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $date)->diffForHumans();
    }
    public function user_post_rating(){
        return $this->hasMany(Rating::class);
    }
    public function chat_user(){
        return $this->belongsToMany(User::class,'chat_lists','user_id','chat_id')->withTimestamps()->withPivot('id');
    }
    public function chat_me(){
        return $this->belongsToMany(User::class,'chat_lists','chat_id','user_id')->withTimestamps()->withPivot('id');
    }
    public function have_chat(){
        return $this->chat_user()
        ->get()
        ->merge($this->chat_me()
        ->get())
        ;
    }
    public function sender(){
        return $this->belongsToMany(User::class,'private_messages','sender_id','receiver_id')->withTimestamps();
        
    }
      public function receiver(){
        return $this->belongsToMany(User::class,'private_messages','receiver_id','sender_id');
        
    }

}
