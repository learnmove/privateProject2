<?php

namespace App\Entities;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Illuminate\Database\Eloquent\Model;
class User extends Model implements Transformable
{
    use TransformableTrait;

     use Notifiable;
     protected $table="users";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['school_id',
        'name', 'email', 'password','account'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
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
}
