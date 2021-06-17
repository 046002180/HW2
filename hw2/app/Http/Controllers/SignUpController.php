<?php

namespace app\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Session;
use App\Models\pvtClient;

class SignUpController extends BaseController
{
    public function signup()
    {
        $user = Session::get('lambda_user', null);
        if ($user !== null)
            return redirect('userarea');
        return view('signup');
    }

    public function addUser()
    {   
        $regex_string = '/[0-9\|\!\"\£\$\%\&\/\(\)\=\?\^\*\{\}\[\]\+\@\#\§\°]/';
        $regex_number_control = '/^(?=.*[0-9])[A-Za-z0-9@$!%*.#?&§^_"£=€°\/{}\[\[\]\|\-\(\)\/]{8,16}$/';
        $regex_special_character_control = '/^(?=.*[@$!%*.#?&§^_"£=€°\/{}\[\]\|\-\(\)\/])[A-Za-z0-9@$!%*.#?&§^_"£=€°\/{}\[\[\]\|\-\(\)\/]{8,16}$/';
        $name = request('name', null);
        $surname = request('surname', null);
        $state = request('state', null);
        $address = request('address', null);
        $email = request('email', null);
        $password = request('password', null);
        $password2 = request('password2', null);
        $city = request('city', null);
        $number = request('number', null);
        if (
            $name === null || $surname === null || $state === null || $address === null || $email === null || $password === null
            || $password2 === null || $city === null || $number === null
        ) {
            $error = "Compila tutti i campi";
            return view("signup")->with("error", $error);
        }
        if (preg_match($regex_string, $name)) {
            $error = "Nome non valido";
            return view("signup")->with("error", $error);
        }
        if (preg_match($regex_string, $surname)) {
            $error = "Cognome non valido";
            return view("signup")->with("error", $error);
        }
        if (preg_match($regex_string, $state)) {
            $error = "Stato non valido";
            return view("signup")->with("error", $error);
        }
        if (!preg_match('/^(?!.*[a-zA-z])[0-9]+$/', $number)) {
            $error = "Numero non valido";
            return view("signup")->with("error", $error);
        }
        if (preg_match($regex_string, $city)) {
            $error = "Città non valida";
            return view("signup")->with("error", $error);
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = "Email non valida";
            return view("signup")->with("error", $error);
        }
        if (strcmp($password, $password2) !== 0) {
            $error = "Le password non coincidono";
            return view('signup')->with('error', $error);
        }
        if (strlen($password) < 8) {
            $error = "La password inserita è troppo corta";
            return view('signup')->with('error', $error);
        }
        if (strlen($password) > 16) {
            $error = "La password inserita è troppo lunga";
            return view('signup')->with('error', $error);
        }
        if (!preg_match($regex_number_control, $password)) {
            $error = "La password non contiene numeri";
            return view('signup')->with('error', $error);
        }
        if (!preg_match($regex_special_character_control, $password)) {
            $error = "La password non contiene caratteri speciali";
            return view('signup')->with('error', $error);
        }
        //dati validi
        $res = pvtClient::find($email);
        if ($res != null) {
            $error = "Email già in uso";
            return view("signup")->with('error', $error);
        }
        $user = new pvtClient;
        $user->Email = $email;
        $password = hash('sha256', $password);
        $password = base64_encode($password);
        $user->Password = $password;
        $user->Nome = $name;
        $user->Cognome = $surname;
        $user->Indirizzo = $city . ',' . $address . ',' . $number;
        $user->Stato = $state;
        if ($user->save()) {
            Session::put('lambda_user', $email);
            return redirect('userarea');
        }
        $error='Registrazione fallita';
        return view('signup')->with('error',$error);
    }
}
