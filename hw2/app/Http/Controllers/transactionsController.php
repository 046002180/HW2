<?php

namespace app\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\pvtClient;

class transactionsController extends BaseController
{


    public function retrieve(Request $request)
    {
        $user = Session::get('lambda_user');
        if ($user === null)
            return abort(403);
        $request->validate([
            'user' => ['required', 'email:rfc,filter']
        ]);

        $user = pvtClient::find($request->user);
        if ($user !== null) {
            $transaction = $user->transactions->toArray();
            $copies = $user->transactions;
            $length = count($transaction);
            if ($length > 0) {
                if ($length > 1) {
                    $response = array();
                    foreach ($transaction as $key => $value) {
                        $response[$key] = array('Id' => $transaction[$key]['Id'], 'Data' => $transaction[$key]['DATA'], 'Metodo' => $transaction[$key]['Metodo'], 'Num.Metodo' => $transaction[$key]['Numero_metodo'], 'Importo' => $transaction[$key]['Importo']);
                        $id = (int)$transaction[$key]['Id'];
                        $tmp = $copies->find($id)->copies->toArray();
                        $tmp = array_count_values(array_column($tmp, 'Software'));
                        foreach ($tmp as $k => $v)
                            $response[$key]['Prodotti'][] = $k . ',' . $v;
                    }
                } else {
                    $response[0] = array('Id' => $transaction[0]['Id'], 'Data' => $transaction[0]['DATA'], 'Metodo' => $transaction[0]['Metodo'], 'Num.Metodo' => $transaction[0]['Numero_metodo'], 'Importo' => $transaction[0]['Importo']);
                    $id = (int)$transaction[0]['Id'];
                    $tmp = $copies->find($id)->copies->toArray();
                    $tmp = array_count_values(array_column($tmp, 'Software'));
                    foreach ($tmp as $k => $v)
                        $response[0]['Prodotti'][] = $k . ',' . $v;
                }
                return response()->json($response);
            } else {
                $response = array('error' => "No transaction found");
                return response()->json($response);
            }
        }
        return abort(400);
    }
}
