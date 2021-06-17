<?php

namespace app\Models;
use Illuminate\Database\Eloquent\Model;

class software extends Model{
    
    protected $table='software';
    protected $primaryKey='Nome';
    protected $autoincrement=false;
    protected $keyType='string';
    protected $guarded=['*'];

    public function copies(){
        return $this->hasMany('App\Models\pvtCopy','software');
    }
}
