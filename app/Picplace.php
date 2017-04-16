<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Picplace extends Model
{
    //fillable
    protected $fillable = ['idPlace','url','created_at','updated_at'];
    public function place(){
        return $this->belongsTo('App\Place','id','idPlace');
        
    }
}
