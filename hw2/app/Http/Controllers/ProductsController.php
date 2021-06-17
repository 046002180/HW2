<?php

namespace app\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cookie;

class ProductsController extends BaseController
{
    public function products(){
        return view('products');
    }

    public function purchase(){
        $array=request('list');
        Cookie::forget('cartcookie');
        $value = 'Prodotti : ';
        foreach ($array as $key => $val)
        $value = $value . "," . $val;
        return redirect('cart')->withCookie(cookie('cartcookie',$value,3600,null,null,null,false,false,null));
    }
}