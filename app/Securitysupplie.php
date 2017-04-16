<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Securitysupplie extends Model
{
    //
    protected $fillable = ['idRequeriments','cantidad','tipo','observaciones','created_at','updated_at'];
    protected $table = 'securitysupplies';
    public function logisticrequiriment(){
        return $this->belongsTo('App\Logisticrequiriment','id','idRequeriments');
    }
}
