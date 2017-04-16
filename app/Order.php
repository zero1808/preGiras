<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //fillable
    protected $fillable=['idEvent','idTeam','status','created_at','updated_at'];
    protected $table='orders';
    
    public function teams(){
        return $this->hasMany('App\Team','id','idTeam');
    }
    
    public function events(){
        return $this->belongsTo('App\Event','id','idEvent');
    }
}
