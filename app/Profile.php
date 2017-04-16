<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model {

    //fillable
    protected $fillable = ['id_user','name', 'ap_paterno', 'ap_materno', 'direccion', 'idMunicipio', 'telefono_cel', 'telefono_casa', 'status', 'created_at', 'updated_at', 'idTeam'];
    protected $table = 'profiles';

    public function user() {
        return $this->belongsTo('App\User','id','id_user');
    }
    public function municipality() {
        return $this->hasOne('App\Municipality', 'id', 'idMunicipio');
    }
    public function team() {
        return $this->hasOne('App\Team','id','idTeam');
    }
    public function event() {
        return $this->belongsTo('App\Event','idResponsable','id');
    }
}
