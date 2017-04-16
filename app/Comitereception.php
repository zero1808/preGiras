<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comitereception extends Model
{
    //fillable
    protected $fillable=['idInformation','nombre','cargo','observaciones','foto','created_at','updated_at'];
    protected $table='comitereceptions';
    
    public function information(){
        return $this->belongsTo('App\Information','id','idInformation');
    }
}
