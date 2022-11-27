<?php

// šablona Účet

// urceni globalnich promennych, se kterymi sablona pracuje
global $tplData;

// HTML
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

// Výpis osobních údajů
if(array_key_exists('userData', $tplData)) {

    // Cyklus proběhne jenom 1
    foreach($tplData['userData'] as $u){
        $res .= "
<form method='POST'>
    <input type='hidden' name='id_uzivatel' value=$u[id_user]>
    <div class='container'>
        <div class='jumbotron'>
            <h2 class='text-center'>Úprava osobních údajů:</h2><br>
            <div class=row>
                <table class='table'>
                <tbody>
                <tr>
                    <td class='col-2'>Login:</td>
                    <td class='col-10'>$u[login]</td>
                </tr>
                <tr>
                    <td class='col-2'>Heslo 1:</td>
                    <td class='col-10'><input type='password' name='heslo' id='pas1' class='form-control' required></td>
                </tr>
                <tr>
                    <td class='col-2'>Heslo 2:</td>
                    <td class='col-10'><input type='password' name='heslo2' id='pas2' class='form-control' required></td>
                </tr>
                <tr>
                    <td class='col-2'>Jméno:</td>
                    <td class='col-10'><input type='text' name='jmeno' value='$u[name]' class='form-control' required></td>
                </tr>
                <tr>
                    <td class='col-2'>E-mail:</td>
                    <td class='col-10'><input type='email' name='email' value='$u[email]' class='form-control' required></td>
                </tr>
                <tr>
                    <td class='col-2'>Současné heslo:</td>
                    <td class='col-10'><input type='password' name='heslo_puvodni' class='form-control' required></td>
                </tr>

                </tbody>
                </table>
                <div class='col text-center'>
                    <input type='submit' name='action' value='Upravit osobní údaje' class='btn btn-primary'>
                </div>
            </div>
        </div>
    </div>
</form>
        ";
    }

    // Vypíše všechny recenze
    foreach ($tplData['reviews'] as $r) {

        //vykreslí hodnocení pomocí funkce drawStar()
        $stars = drawStar($r['rating']);

        // vypíše viditelnost slovy
        $visibility = $r['hidden'] ? "Soukromý" : "Veřejný";

        // recenze
        $res .="
<div class=container>
    <div class=jumbotron>
            <form method='POST'>
                <table class='table table-borderless'>
                    <tbody>
                    <tr>
                        <td class=col-2>Nadpis:</td>
                        <td class='col-10'>$r[title]</td>
                    </tr>
                    <tr>
                        <td class=col-2>Kód produktu:</td>
                        <td class='col-10'>$r[id_product]</td>
                    </tr>
                    <tr>
                        <td class=col-2>Text recenze:</td>
                        <td class='col-10'>$r[text]</td>
                    </tr>
                    <tr>
                        <td class=col-2>Hodnocení:</td>
                        <td class='col-10'>$stars $r[rating]/100</td>
                    </tr>
                    <tr>
                        <td class=col-2>Viditelnost:</td>
                        <td class='col-10'>$visibility</td>
                    </tr>
                    </tbody>
                </table>
                <div class='col text-center'>
                    <input type='hidden' name='vis' value='$r[hidden]'>
                    <input type='hidden' name='idRev' value='$r[id_review]'>
                    <button type='submit' class='btn btn-primary'>Změna viditelnosti.</button>
                </div>
            </form>
    </div>
</div>
        ";
    }


}

// Hláška pro nepřihlášené uživatele
else {
    $res .= "
<div class='container'>
    <div class='alert alert-info'>
        <strong>Info!</strong> Uživatel není přihlášen.
    </div>
</div>
        ";
}

//výpis stránky
echo $res;

/**
 * @param int $rating Hodnocení
 * @return string HTML kód
 */
function drawStar(int $rating):string {
    $stars = "";

    for ($i = 0; $i < 100; $i += 20) {
        if ($i < $rating) {
            $stars .= "<i class='fas fa-star'></i>";
        } else {
            $stars .= "<i class='far fa-star'></i>";
        }
    }

    return $stars;
}
