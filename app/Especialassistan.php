<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Especialassistan extends Model
{
    //fillable
    protected $fillable = ['numero','idProgram','nombre','cargo','observaciones','foto','created_at','updated_at'];
    protected $table = 'especialassistans';
    
    public function program(){
        return $this->belongsTo('App\Program','id','idProgram');
    }
}
