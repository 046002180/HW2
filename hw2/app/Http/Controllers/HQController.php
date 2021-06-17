<?php

namespace app\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;

class HQController extends BaseController
{
    public function hq(){
        return view('hq');
    }
}