<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    //fillable
    protected $fillable=['nombre','status','created_at','updated_at'];
    protected $table = 'teams';
    
    public function profile(){
        return $this->belongsTo('App\Profile','idTeam','id');
    }
    public function order(){
        return $this->belongsTo('App\Orders','idTeam','id');
    }
    
}
