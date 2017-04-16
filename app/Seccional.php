<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Seccional extends Model {

    //fillable
    protected $fillable = ['id_externo', 'distrito', 'entidad', 'geometry', 'external_id', 'folder', 'municipio', 'seccion', 'tipo', 'coordinates', 'created_at', 'updated_at'];
    protected $table = 'seccionals';

    public function municipality() {
        return $this->belongTo('App\Municipality', 'id', 'municipio');
    }

}
