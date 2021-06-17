<?php 

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use App\Models\software;
use Illuminate\Support\Facades\Session;

class pInfoController extends BaseController{

    public function retrieve(){
        
        $user=Session::get('lambda_user');
        if($user===null)
           return abort(403);
        $path=array(
            'aerolab'=>'/hw2/public/img/prodotti/aero.png',
            'easyoffice'=>'/hw2/public/img/prodotti/eo.jpg',
            'galileo'=>'/hw2/public/img/prodotti/gl.png',
            'photoedit'=>'/hw2/public/img/prodotti/pe.jpg',
            'v.i.a.d.'=>'/hw2/public/img/prodotti/viad.png',
            'videoedit'=>'/hw2/public/img/prodotti/ve.jpg',
        );
        $output=array();
        $softwares=software::all();
        foreach($softwares as $software){
            $key=strtolower($software->Nome);
            if(array_key_exists($key,$path))
                $output[$key]=array('Prezzo'=>$software->Costo_licenza,'Img'=>$path[$key]);
        }
        return response()->json($output);  
    }
}
