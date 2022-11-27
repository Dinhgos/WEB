<?php

// šablona Login

// urceni globalnich promennych, se kterymi sablona pracuje
global $tplData;

$res = "";

// Vypíše hlášku
if(isset($tplData['echo'])){
    echo "

<div class='container'>
    <div class='alert alert-info'>
        <strong>Info!</strong> $tplData[echo]
    </div>
</div>
    ";
}

// Testuje jestli je uživatel přihlášen
if(isset($tplData['isLoggedIn'])){

    //Uživatel není přihlášen
    if ($tplData['isLoggedIn'] == false) {

        $res .= "

<div class='container'>
    <div class='jumbotron'>
        <h2>Přihlášení uživatele:</h2><br>
        <td>
            <form class='was-validated' method='post' >
                <div>
                    <label for='login'>Login:</label>
                    <input type='text' id='login' name='login' class='form-control' required>
                    <div class='valid-feedback'>OK.</div>
                    <div class='invalid-feedback'>Prosím, vyplňte toto pole.</div>
                    <br>
                </div>
                <div>
                    <label for='password'>Heslo:</label>
                    <input type='password' id='password' name='heslo' class='form-control' required>
                    <div class='valid-feedback'>OK.</div>
                    <div class='invalid-feedback'>Prosím, vyplňte toto pole.</div>
                </div>
                <div>
                    <br>
                    <input type='hidden' name='action' value='login'>
                    <button type='submit' name='potvzeni' value='SignIn' class='btn btn-primary'>Přihlásit</button>
                </div>
            </form>
        </td>
    </div>
</div>
        ";
    }

    //Uživatel je přihlášen
    elseif ($tplData['isLoggedIn'] == true) {
        foreach($tplData['users'] as $u){
            $res .= "
        
<div class='container'>
    <div class='jumbotron'>
        <h2>Odhlášení uživatele:</h2><br>

        <p>Právě přihlášený uživatel: <mark>$u[name]</mark></p>

        <form method='POST'>
            <input type='hidden' name='action' value='logout'>
            <input type='submit' name='potvrzeni' value='Odhlásit' class='btn btn-primary'>
        </form>
    </div>
</div>
        
        ";
        }
    }
}

echo $res;