<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class pvtClient extends Model
{
    protected $table='cliente_privato';
    protected $primaryKey='Email';
    protected $autoIncrement=false;
    protected $keyType='string';
    protected $fillable=['Email','Password','Nome','Cognome','Indirizzo','Stato'];
    protected $hidden = ['Password','Indirizzo','Stato'];
    public $timestamps=false;

    public function transactions()
    {
        return $this->hasMany('App\Models\transaction','email_cliente');
    }
    public function reports(){
        return $this->hasMany('App\Models\report','cliente');
    }
}
