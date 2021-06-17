<?php

namespace app\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Session;
use App\Models\pvtClient;

class LoginController extends BaseController
{
    public function login()
    {
        $user = Session::get('lambda_user', null);
        if ($user !== null)
            return redirect('userarea');
        return view('login');
    }
    public function checkCredentials()
    {   
        $password_regex_number_control = '/^(?=.*[0-9])[A-Za-z0-9@$!%*.#?&§^_"£=€°\/{}\[\[\]\|\-\(\)\/]{8,16}$/';
        $password_regex_special_character_control = '/^(?=.*[@$!%*.#?&§^_"£=€°\/{}\[\]\|\-\(\)\/])[A-Za-z0-9@$!%*.#?&§^_"£=€°\/{}\[\[\]\|\-\(\)\/]{8,16}$/';
        $email = request('email', null);
        $password = request('password', null);
        if ($email === null) {
            $error = "Inserisci email";
            return view('login')->with('error',$error);
        } elseif ($password === null) {
            $error = "Inserisci password";
            return view('login')->with('error',$error);
        } else {
            if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                $error = "Email non valida";
                return view('login')->with('error', $error);
            } elseif (
                !preg_match($password_regex_number_control, $password) || !preg_match($password_regex_special_character_control, $password)
                || strlen($password) > 16 || strlen($password) < 8
            ) {
                $error = "Password non valida";
                return view('login')->with('error', $error);
            } else {
                //credenziali ammissibili
                $password = hash("sha256", $password);
                $password = base64_encode($password);
                $result = pvtClient::where('email', $email)->where('password', $password)->first();
                if ($result !== null) {
                    Session::put('lambda_user',$email);
                    return redirect('userarea');
                }
                else{
                    //credenziali errate
                    $error="Credenziali errate";
                    return view('login')->with("error",$error);
                }
            }
        }
    }
}
