<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Materialresource extends Model {

    //fillable
    protected $fillable = ['idRequeriments', 'cantidad', 'tipo', 'observaciones', 'created_at', 'updated_at'];
    protected $table = 'materialresources';

    public function logisticrequiriment() {
        return $this->belongsTo('App\Logisticrequiriment', 'id', 'idRequeriments');
    }

}
