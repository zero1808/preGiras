<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Information extends Model
{
    //fillable
    protected $fillable = ['idEvent','tipo_evento','vestimenta','sugerencia_vestimenta','rentabilidad','trascendencia','asistentes','participacion','sector','tema','folletos','utilitarios','created_at','updated_at'];
    protected $table= 'informations';
    
    public function event(){
        return $this->belongsTo('App\Event','id','idEvent');
    }
    public function comitereceptions(){
        return $this->hasMany('App\Comitereception','idInformation','id');
    }
}
