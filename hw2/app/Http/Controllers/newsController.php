<?php 

namespace app\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class newsController extends BaseController{

    public function fetch(Request $request){
        
        $request->validate([
            'argument'=> ['required',
                          'string',
                          Rule::in(['cyber-attack','cyber-security','data-breach'])
                        ],
        ]);

        $response=Http::get(
            env('NEWS_ENDPOINT'),[
            'q'=> $request->argument,
            'api-key' => env('NEWS_API_KEY'),
            ]);
        if ($response->failed()) abort(500);
        return response()->json(json_decode($response));


    }
}



?>