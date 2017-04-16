<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Presidiummember extends Model
{
    //fillable
    protected $fillable = ['idProgram','numero','nombre','cargo','foto','created_at','updated_at'];
    protected $table = 'presidiummembers';
    public function program(){
        return $this->belongsTo('App\Program','id','idProgram');
    }
}
