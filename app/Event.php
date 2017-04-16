<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    //fillable
    protected $fillable=['nombre','f_inicio','f_final','hora_arribo','hora_convocatoria','calle_numero','colonia','cp','idMunicipio','seccion_impactada','distrito_impactado','responsable_politico','cargo_responsable_politico','foto_responsable_politico','telefono_responsable_politico','email_responsable_politico','responsable_operativo','cargo_responsable_operativo','foto_responsable_operativo','telefono_responsable_operativo','email_responsable_operativo','objetivo','idResponsable','status','lat','lng','contador_pdf','created_at','updated_at'];
    protected $table='events';
    
    public function municipality() {
        return $this->hasOne('App\Municipality','id','idMunicipio');
    }
    public function profile(){
        return $this->hasOne('App\Profile','id','idResponsable');
    }
    
    public function orders(){
        return $this->hasMany('App\Order','idEvent','id');
    }
    public function information(){
        return $this->hasOne('App\Information','idEvent','id');
    }
    public function place(){
        return $this->hasOne('App\Place','idEvent','id');
    }
    public function program(){
        return $this->hasOne('App\Program','idEvent','id');
    }
    public function logisticrequiriment(){
        return $this->hasOne('App\Logisticrequiriment','idEvent','id');
    }
}

