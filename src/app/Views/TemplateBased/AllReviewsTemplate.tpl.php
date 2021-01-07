<?php

// šablona Všech recenzí

// urceni globalnich promennych, se kterymi sablona pracuje
global $tplData;

// HTML
$res = "";

// Hláška
if(isset($tplData['echo'])){
    echo "
<div class='container'>
    <div class='alert alert-info'>
        <strong>Info!</strong> $tplData[echo]
    </div>
</div>
    ";
}

// Testuje zda uživatel je přihlášen a má dostatečný právo
// Dále testuje jestli v $tplData jsou recenze
if ($tplData['isLoggedIn'] && $tplData['right'] > 2) {
    if (isset($tplData['reviews'])) {
        foreach ($tplData['reviews'] as $r) {

            // Vykreslí hodnocení
            $stars = drawStar($r['rating']);

            // Vypíše viditelnost
            $visibility = $r['hidden'] ? "Soukromý" : "Veřejný";

            // Recenze
            $res .= "
<div class=container>
    <div class=jumbotron>
        <form method='POST'>
            <table class='table table-borderless'>
                <tr>
                    <td class='col-2'>Nadpis:</td>
                    <td class='col-10'>$r[title]</td>
                </tr>
                <tr>
                    <td class='col-2'>Kód produktu:</td>
                    <td class='col-10'>$r[id_product]</td>
                </tr>
                <tr>
                    <td class='col-2'>Text recenze:</td>
                    <td class='col-10'>$r[text]</td>
                </tr>
                <tr>
                    <td class='col-2'>Hodnocení:</td>
                    <td class='col-10'>$stars $r[rating]/100</td>
                </tr>
                <tr>
                    <td class='col-2'>Viditelnost:</td>
                    <td class='col-10'>$visibility</td>
                </tr>
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
}

// Hláška pro nepřihlášené uživatele
else {
    $res .= "
<div class='container'>
    <div class='alert alert-info'>
        <strong>Info!</strong> Jenom správce může spravovat recenze.
    </div>
</div>
    ";
}

// Výpis HTML
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
