<?php   

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class report extends Model
{
    protected $table='report_p';
    protected $primaryKey='Codice';
    protected $autoIncrement=false;
    protected $fillable=['Cliente','Software','Descrizione'];
    public $timestamps=false;

    public function generatedBy()
    {
        return $this->belongsTo('App\Models\pvtClient','Cliente','email');
    }
}
