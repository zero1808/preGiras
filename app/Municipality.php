<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Municipality extends Model {

    //fillable
    protected $fillable = ['name', 'state', 'created_at', 'updated_at'];
    protected $table = 'municipalities';

    public function profile() {
        return $this->belongsTo('App\Profile','idMunicipio','id');
    }

    public function event() {
        return $this->belongsTo('App\Event','idMunicipio','id');
    }
    
    public function seccionals(){
        return $this->hasMany('App\Seccional','municipio','id');
    }
}
