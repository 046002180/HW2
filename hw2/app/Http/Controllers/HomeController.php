<?php
namespace app\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;

class HomeController extends BaseController
{
    public function home(){
        return view('home');
    }
}
