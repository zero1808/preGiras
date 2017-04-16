<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Firstline extends Model
{
    //fillable
    protected $fillable = ['idProgram','nombre','cargo','observaciones','foto','linea','created_at','updated_at'];
    protected $table = 'firstlines';
    
    public function program(){
        return $this->belongsTo('App\Program','id','idProgram');
    }
}
