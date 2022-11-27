<?php

// šablona Produkty

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

// Testuje zda je přihlášen administrátor
if (isset($tplData['showAdmin']) && $tplData['showAdmin']) {
    $res .= "
<div class='container'>
    <div class='jumbotron'>
        <h2 style='text-align:center;'>Přidat produkt:</h2><br>
        <form method='post'>
            <div class='form-group'>
                <label for='name'>Název:</label>
                <input type='text' class='form-control' id='name' name='name'>
            </div>
            <div class='form-group'>
                <label for='price'>cena:</label>
                <input type='number' class='form-control' id='price' name='price'>
            </div>
            <div class='form-group'>
                <label for='description'>Popis produktu:</label>
                <textarea class='form-control' rows='5' id='description' name='description'></textarea>
            </div>
            <div class='col text-center form-group'>
                <button type='submit' class='btn btn-primary' name='addProduct'>Přidat</button>
            </div>
        </form>
    </div>
</div>
    ";

    // nastaví řádky tabulky
    if (isset($tplData['products'])) {
        $productInfo = "";

        foreach ($tplData['products'] as $p) {
            $productInfo .= "
<tr>
    <td>$p[id_product]</td>
    <td>$p[name]</td>
    <td>
        <form method='post'>
            <input type='hidden' name='id_product' value='$p[id_product]'>
            <button type='submit' name='action' value='delete' class='btn btn-primary'>Smazat</button>
        </form>
    </td>
</tr>
        ";
        }

        // Tabulka
        $res .= "
<div class='container'>
    <div class='jumbotron table-responsive'>
        <h2 class='text-center'>Tabulka produktů:</h2>
        <table class='table table-bordered table-secondary text-dark'>
            <thead>
            <tr>
                <th>ID</th>
                <th>Název</th>
                <th>Akce</th>
            </tr>
            </thead>
            <tbody>
                $productInfo
            </tbody>
        </table>
    </div>
</div>
        ";
    }
}

// Vypíše jednotlivé produkty
if(array_key_exists('product', $tplData)) {

    // Uživatel je přihášen
    if ($tplData["isLoggedIn"] && $tplData['right'] > 1) {
        foreach ($tplData['product'] as $d) {

            $res .= "
        
<div class='container'>
    <div class='jumbotron'>
        <div class='row'>
            <table class='table table-borderless'>
                <tbody>
                <tr>
                    <td class='col-2'>Název produktu</td>
                    <td class='col-10'>$d[name]</td>
                </tr>
                <tr>
                    <td class='col-2'>Kód produktu:</td>
                    <td class='col-10'>$d[id_product]</td>
                </tr>
                <tr>
                    <td class='col-2'>Popisek:</td>
                    <td class='col-10'>$d[description]</td>
                </tr>
                <tr>
                    <td class='col-2'>Cena:</td>
                    <td class='col-10'>$d[price]</td>
                </tr>
                </tbody>
            </table>
            <div class='col text-center'>
                <table class='table table-borderless'>
                    <tr>
                        <td>
                            <form action='http://localhost/WEB/SP/src/index.php?page=review' method='post'>
                                <input type='hidden' name='id_product' value='$d[id_product]'/>
                                <input type='submit' value='Přidat recenzi' class='btn btn-primary'/>
                            </form>
                        </td>
                        <td>
                            <form action='http://localhost/WEB/SP/src/index.php?page=prReview' method='post'>
                                <input type='hidden' name='id_product' value='$d[id_product]'/>
                                <input type='submit' value='Zobrazit recenze' class='btn btn-primary'/>
                            </form>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
        
        ";
        }
    }

    // Uživatel není přihášen
    else {
        foreach ($tplData['product'] as $d) {
            $res .= "
<div class=container>
    <div class=jumbotron>
        <div class=row>
            <table class='table table-borderless'>
                <tbody>
                <tr>
                    <td class=col-2>Název produktu</td>
                    <td class='col-10'>$d[name]</td>
                </tr>
                <tr>
                    <td class=col-2>Kód produktu:</td>
                    <td class='col-10'>$d[id_product]</td>
                </tr>
                <tr>
                    <td class=col-2>Popisek:</td>
                    <td class='col-10'>$d[description]</td>
                </tr>
                <tr>
                    <td class=col-2>Cena:</td>
                    <td class='col-10'>$d[price]</td>
                </tr>
                </tbody>
            </table>
            <div class='col text-center'>
                <form action='http://localhost/WEB/SP/src/index.php?page=prReview' method='post'>
                    <input type='hidden' name='id_product' value='$d[id_product]'/>
                    <input type='submit' value='Zobrazit recenze' class='btn btn-primary'/>
                </form>
            </div>
        </div>
    </div>
</div>
        ";
        }
    }
} else {
    $res .= "produkty nenalezeny";
}

echo $res;
