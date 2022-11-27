<?php

// šablona Recenze

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
if(isset($tplData['isLoggedIn']) && $tplData['isLoggedIn'] == true) {

    // Formulář pro recenzi
    $res .= "
    
<div class='container'>
    <div class='jumbotron'>
        <h2 style='text-align:center;'>Napsat recenzi:</h2><br>
        <form method='post'>
        <div>Produkt:<br>$tplData[id_product]</div>
        <input type='hidden' name='id_product' value='$tplData[id_product]'>
            <div class='form-group'>
                <label for='sel1'>Hodnocení:</label>
                <select class='form-control' id='sel1' name='sellist1'>
                    <option value='20'>20</option>
                    <option value='40'>40</option>
                    <option value='60'>60</option>
                    <option value='80'>80</option>
                    <option value='100'>100</option>
                </select>
            </div>
            <div class='form-group'>
                <label for='title'>Nadpis:</label>
                <input type='text' class='form-control' id='title' name='title'>
            </div>
            <div class='form-group'>
                <label for='comment'>Text recenze:</label>
                <textarea class='form-control' rows='5' id='comment' name='comment'></textarea>
            </div>
            <div class='col text-center form-group'>
                <input type='hidden' name='send'>
                <button type='submit' class='btn btn-primary'>Odeslat</button>
            </div>
        </form>

    </div>
</div>
    
    ";
}

// Hláška pro nepřihlášeného uživatele
else {
    $res .= "
<div class='container'>
    <div class='alert alert-info'>
        <strong>Info!</strong> Uživatel není přihlášen.
    </div>
</div>
    ";
}

echo $res;
