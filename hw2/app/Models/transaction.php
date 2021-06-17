<?php

namespace app\Models;
use Illuminate\Database\Eloquent\Model;

class transaction extends Model
{
    protected $table='transazione';
    protected $primaryKey='Id';
    protected $autoIncrement=true;
    public $timestamps=false;
    protected $fillable=['Email_cliente','Metodo','Nome_intestatario','Cognome_intestatario',
                         'Numero_metodo','Importo','Data'];
    
    public function pvtClient(){
        return $this->belongsTo('App\Models\pvtClient','Email_cliente','email');
    }
    public function copies(){
        return $this->hasMany('App\Models\pvtCopy','id_transazione');
    }
}

?>