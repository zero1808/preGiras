<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    //fillable
    protected $fillable = ['idEvent','lugar','descripcion','acceso_lugar','imagen_frente','imagen_atras','imagen_exterior','riesgos','problematica','created_at','updated_at'];

    protected $table = 'places';
    
    public function event(){
        return $this->belongTo('App\Event','id','idEvent');
    }
    public function picplaces(){
        return $this->hasMany('App\Picplace','idPlace','id');
    }
    public function bossplaces(){
        return $this->hasMany('App\Bossplace','idPlace','id');
    }
}
