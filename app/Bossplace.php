<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bossplace extends Model
{
    //fillable
    protected $fillable = ['idPlace','nombre','cargo','observaciones','created_at','updated_at'];
    protected $table = 'bossplaces';
    
    public function place(){
        return $this->belongsTo('App\Place','id','idPlace');
    }
    
}
