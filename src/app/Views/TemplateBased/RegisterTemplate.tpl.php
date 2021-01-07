<?php

// šablona Recenze produktu

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
if(isset($tplData['isLoggedIn'])) {

    // Registrační formulář
    if ($tplData['isLoggedIn'] == false) {
        $res .= "
        
<div class='container'>
    <div class='jumbotron'>
        <h2>Registrační formulář:</h2><br>
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
                    <label for='password1'>Heslo 1:</label>
                    <input type='password' id='password1' name='password1' class='form-control' required>
                    <div class='valid-feedback'>OK.</div>
                    <div class='invalid-feedback'>Prosím, vyplňte toto pole.</div>
                    <br>
                </div>
                <div>
                    <label for='password2'>Heslo 2:</label>
                    <input type='password' id='password2' name='password2' class='form-control' required>
                    <div class='valid-feedback'>OK.</div>
                    <div class='invalid-feedback'>Prosím, vyplňte toto pole.</div>
                    <br>
                </div>
                <div>
                    <label for='name'>Jméno:</label>
                    <input type='text' id='name' name='name' required class='form-control'>
                    <div class='valid-feedback'>OK.</div>
                    <div class='invalid-feedback'>Prosím, vyplňte toto pole.</div>
                    <br>
                </div>
                <div>
                    <label for='email'>Email:</label>
                    <input type='email' id='email' name='email' required class='form-control'>
                    <div class='valid-feedback'>OK.</div>
                    <div class='invalid-feedback'>Prosím, vyplňte toto pole.</div>
                </div>
                <div>
                    <br>
                    <input type='hidden' name='action' value='register'>
                    <button type='submit' value='SignIn' class='btn btn-primary'>Vytvořit účet</button>
                </div>
            </form>
        </td>
    </div>
</div>
        
        ";

    }

    // Hláška pro přihlášeneho uživatele
    elseif ($tplData['isLoggedIn'] == true) {
        $res .= "

<div class='container'>
    <div class='alert alert-info'>
        <strong>Info!</strong> Přihlášený uživatel se nemůže znovu registrovat.
    </div>
</div>

        ";
    }

    // Chyba
    else {

        $res .= "
<div class='container'>
    <div class='alert alert-warning'>
        <strong>Warning!</strong> Unknown user status
    </div>
</div>
        ";

    }
}

// Chyba
else {

    $res .= "
<div class='container'>
    <div class='alert alert-warning'>
        <strong>Info!</strong> Missing user status
    </div>
</div>
        ";

}

echo $res;