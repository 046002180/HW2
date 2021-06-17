<?php

namespace app\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Http\Request;
use App\Models\pvtClient;
use App\Models\transaction;
use App\Models\pvtCopy;
use App\Models\software;



class CartController extends BaseController
{
    public function cart()
    {
        $user = Session::get('lambda_user', null);
        if ($user === null)
            return redirect('login');
        $cookie = Cookie::get('cartcookie');
        if ($cookie === null)
            return redirect('products');
        return view('cart');
    }

    public function confirmedTransaction(Request $request)
    {
        $method = request('metodo_pagamento', null);
        $name = request('nome', null);
        $surname = request('cognome', null);
        $num_method = request('numero_metpagamento', null);
        $code = request('codice', null);
        if ($method === null || $name === null || $surname === null || $num_method === null || $code === null) {
            $error = true;
            $arr_error['form_error'] = 'Compila tutti i campi';
            return view('cart')->with('arr_error', $arr_error);
        }
        if (preg_match('/[0-9!"£$%&\(\/\)\=\?\^\{\[\]\+\*\{\}@§°]/', $name)) {
            $name_error = "Il valore inserito nel campo nome non è ammesso";
            $error = true;
            $arr_error['name_error'] = $name_error;
        }
        if (preg_match('/[0-9!"£$%&\(\/\)\=\?\^\{\[\]\+\*\{\}@§°]/', $surname)) {
            $surname_error = "Il valore inserito nel campo cognome non è ammesso";
            $error = true;
            $arr_error['surname_error'] = $surname_error;
        }
        if (strcmp($method, 'Carta di credito') !== 0 && strcmp($method, 'Carta prepagata') !== 0) {
            $ivv_error = "Non giocare con il codice html";
            $error = true;
            $arr_error['ivv_error'] = $ivv_error;
        }
        if (!preg_match('/^(?!.*[a-zA-z])[0-9]+$/', $num_method)) {
            $num_error = "Valore non consentito";
            $error = true;
            $arr_error['num_error'] = $num_error;
        }
        if (!preg_match('/^(?!.*[a-zA-z])[0-9]+$/', $code) || (strlen($code) !== 3)) {
            $code_error = "Codice CVV/CVC non ammissibile";
            $error = true;
            $arr_error['code_error'] = $code_error;
        }
        if (!isset($error)) {
            $user = Session::get('lambda_user');
            $products = request('numero_copie', null);
            if ($products === null)
                return view('products')->with('error', 'Errore');
            $totale = 0;
            foreach ($products as $key => $value) {
                $totale += (software::find($key)->Costo_licenza) * $value;
            }
            $transaction = new transaction;
            $transaction->Email_cliente = $user;
            $transaction->Metodo = $method;
            $transaction->Nome_intestatario = $name;
            $transaction->Cognome_intestatario = $surname;
            $transaction->Numero_metodo = $num_method;
            $transaction->Importo = $totale;
            date_default_timezone_set('Europe/Rome');
            $data = date('Y-m-d  G:i:s');
            $transaction->Data = $data;
            $id = transaction::max('id') + 1;
            $transaction->Id = $id;
            DB::beginTransaction();
            if ($transaction->save()) {
                foreach ($products as $key => $value) {
                    $copy_number = pvtCopy::where('Software', $key)->max('Numero') + 1;
                    $software_name = software::find($key)->Nome;
                    if ($value > 1) {
                        for ($i = 0; $i < $value; $i++) {
                            $copy = new pvtCopy;
                            $copy->Numero = $copy_number;
                            $copy->Id_transazione = $id;
                            $copy->Software = $software_name;
                            if (!$copy->save()) {
                                $error_trs = true;
                                break;
                            }
                            $copy_number++;
                        }
                        if (isset($error_trs))
                            break;
                    } else {
                        $copy = new pvtCopy;
                        $copy->Numero = $copy_number;
                        $copy->Id_transazione = $id;
                        $copy->Software = $software_name;
                        if (!$copy->save()) {
                            $error_trs = true;
                            break;
                        }
                    }
                }
                if (!isset($error_trs)) {
                    DB::commit();
                    $transaction_res = true;
                    $cookie = Cookie::forget('cartcookie');
                    return view('cart')->with('transaction', $transaction_res)->withCookie($cookie);
                }
                DB::rollBack();
                $transaction_res = false;
                return view('cart')->with('transaction', $transaction_res);
            }
            DB::rollBack();
            $transaction_res = false;
            return view('cart')->with('transaction', $transaction_res);
        }
        return view('cart')->with('arr_error', $arr_error);
    }
}
