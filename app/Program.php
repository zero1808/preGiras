<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    //fillable 
    protected $fillable = ['idEvent','contenido','asistentes_ficha','url_contenido','url_programa','estado_entrega','created_at','updated_at'];
    protected $table = 'programs';
    public function event(){
        return $this->belongsTo('App\Event','id','idEvent');
    }
    
    public function presidiummembers(){
        return $this->hasMany('App\Presidiummember','idProgram','id');
    }
    
    public function especialassistans(){
        return $this->hasMany('App\Especialassistan','idProgram','id');
    }
    
    public function dayorders(){
        return $this->hasMany('App\Dayorder','idProgram','id');
    }
    public function firstlines(){
        return $this->hasMany('App\Firstline','idProgram','id');
    }
}
