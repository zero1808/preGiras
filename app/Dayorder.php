<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dayorder extends Model
{
    //fillable
    protected $fillable = ['idProgram','accion','nombre','cargo','minutos','created_at','updated_at'];
    protected $table = 'dayorders';
    
    public function program(){
        return $this->belongsTo('App\Progran','id','idProgram');
    }
}
