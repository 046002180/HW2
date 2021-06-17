<?php

namespace app\Models;
use Illuminate\Database\Eloquent\Model;

class pvtCopy extends Model{

    protected $table='copia_pvt';
    protected $primaryKey='Numero';
    protected $autoIncrement='false';
    protected $fillable=['Numero,Software,Id_transazione'];
    public $timestamps=false;

    public function info(){
        return $this->belongsTo('App\Models\software','Software','Nome');
    }
    public function transaction(){
        return $this->belongsTo('App\Models\transaction','Id_transazione','Id');
    }
}


?>