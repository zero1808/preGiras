<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Logisticrequiriment extends Model
{
    //fillable
    protected $fillable = ['idEvent','seguridad','ambulancia','bomberos','proteccion_civil','maestro_ceremonias','artista','edecanes','tipo_escenario','tipo_estrado','fiscalizacion','responsable_comunicacion','telefono_responsable','pull_cde','medios_locales','medios_nacionales','fotografo','otro_medio','hidratacion','coffeebreak','bocadillos','agua','otro_alimento','responsable_comunicacion','telefono_comunicacion','created_at','updated_at'];
    protected $table = 'logisticrequiriments';
    
    public function event(){
        return $this->belongsTo('App\Event','id','idEvent');
    }
    public function materialresources(){
        return $this->hasMany('App\Materialresource','idRequeriments','id');
    }
    public function imageresources(){
        return $this->hasMany('App\Imageresource','idRequeriments','id');
    }
    
    public function securitysupplies(){
        return $this->hasMany('App\Securitysupplie','idRequeriments','id');
    }
    
}
