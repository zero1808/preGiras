<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Imageresource extends Model
{
    //
    protected $fillable = ['idRequeriments','cantidad','tipo','observaciones','created_at','updated_at'];
    protected $table = 'imageresources';
    
    public function logisticrequiriment(){
        return $this->belongsTo('App\Logisticrequiriment','id','idRequeriments');
    }
}
