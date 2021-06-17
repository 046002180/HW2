<?php

namespace app\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Session;
use App\Models\pvtClient;
use App\Models\report;
use App\Models\software;

class UserAreaController extends BaseController
{
    public function userarea()
    {
        $user = session('lambda_user', null);
        if ($user !== null)
            return view('userarea');
        return redirect('login');
    }
    public function changePassword()
    {
        $regex_number_control = '/^(?=.*[0-9])[A-Za-z0-9@$!%*.#?&§^_"£=€°\/{}\[\[\]\|\-\(\)\/]{8,16}$/';
        $regex_special_character_control = '/^(?=.*[@$!%*.#?&§^_"£=€°\/{}\[\]\|\-\(\)\/])[A-Za-z0-9@$!%*.#?&§^_"£=€°\/{}\[\[\]\|\-\(\)\/]{8,16}$/';
        $current_password = request('current_password', null);
        $password = request('new_password', null);
        $password2 = request('new_password2', null);
        if (
            $current_password === null || $password === null || $password2 === null
        ) {
            $error = "Compila tutti i campi";
            return view("userarea")->with("error", $error);
        }
        if (
            !preg_match($regex_number_control, $current_password) || !preg_match($regex_special_character_control, $current_password)
            || strlen($current_password) < 8 || strlen($current_password) > 16
        ) {
            $error = "Password errata";
            return view("userarea")->with("error", $error);
        }
        if (strcmp($password, $password2) !== 0) {
            $error = "Le password inserite non coincidono";
            return view("userarea")->with("error", $error);
        }
        if (strlen($password) < 8) {
            $error = "La nuova password è troppo corta";
            return view("userarea")->with("error", $error);
        }
        if (strlen($password) > 16) {
            $error = "La nuova password è troppo lunga";
            return view("userarea")->with("error", $error);
        }
        if (!preg_match($regex_number_control, $password)) {
            $error = "La nuova password inserita non contiene numeri";
            return view("userarea")->with("error", $error);
        }
        if (!preg_match($regex_special_character_control, $password)) {
            $error = "La nuova password inserita non contiene caratteri speciali";
            return view("userarea")->with("error", $error);
        }
        $user = pvtClient::find(session('lambda_user'));
        $stored_password = $user->Password;
        $current_password = hash('sha256', $current_password);
        $current_password = base64_encode($current_password);
        if (strcmp($current_password, $stored_password) !== 0) {
            $error = 'Password errata';
            return view('userarea')->with('error', $error);
        }
        $password = hash('sha256', $password);
        $password = base64_encode($password);
        $user->Password = $password;
        if ($user->save()) {
            $Password_changed = true;
            return view('userarea')->with('Password_changed', $Password_changed);
        }
        $Password_changed = false;
        return view('userarea')->with('Password_changed', $Password_changed);
    }
    public function addReport()
    {
        $description = request('description');
        $reported_software = request('software');
        if (strlen($description) === 0) {
            $error = "Descrivi il problema che hai riscontrato.";
            return view('userarea')->with('error', $error);
        }
        if (strlen($description) < 75) {
            $error = 'Descrivi il problema che hai riscontrato in maniera dettagliata';
            return view('userarea')->with('error', $error);
        }
        $rows = software::all();
        $software = [];
        foreach ($rows as $tuple) {
            $software[strtolower($tuple->Nome)] = $tuple->Versione_corrente;
        }
        if (!isset($software[$reported_software])) {
            $error = 'Software non valido';
            return view('userarea')->with('error', $error);
        }
        $user = pvtClient::find(Session::get('lambda_user'));
        $transactions = $user->transactions;
        $copies = [];
        $ownedSoftware = [];
        foreach ($transactions as $transaction) {
            $copies[] = $transaction->copies;
        }
        foreach ($copies as $array) {
            foreach ($array as $copy)
                $ownedSoftware[] = strtolower($copy->info->Nome);
        }
        $ownedSoftware = array_unique($ownedSoftware);
        if (!in_array($reported_software, $ownedSoftware)) {
            $error = "Non possiedi questo software";
            return view('userarea')->with('error', $error);
        }
        $report = new report;
        $report->Cliente = $user->Email;
        $report->Software = $reported_software;
        $report->Descrizione = $description;
        $report->Versione_software = $software[$reported_software];
        $report->Codice = report::max('Codice') + 1;
        if ($report->save()) {
            $Reported = true;
            return redirect('userarea')->with('Reported', $Reported);
        }
        $Reported = false;
        return redirect('userarea')->with('Reported', $Reported);
    }
    public function logout()
    {
        Session::flush();
        return redirect('login');
    }
}
