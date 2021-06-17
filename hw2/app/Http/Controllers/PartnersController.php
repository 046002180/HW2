<?php

namespace app\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;

class PartnersController extends BaseController
{
    public function partners(){
        return view('partners');
    }
}