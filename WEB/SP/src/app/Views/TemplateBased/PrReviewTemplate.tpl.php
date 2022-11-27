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

// jednotlivé recenze
if (isset($tplData['reviews'])) {
    foreach ($tplData['reviews'] as $r) {
        $stars = drawStar($r['rating']);

        $res .= "
<div class=container>
    <div class=jumbotron>
        <div>
            <form method='POST'>
                <table class='table table-borderless'>
                    <tbody>

                    <tr>
                        <td class='col-2'>Nadpis:</td>
                        <td class='col-10'>$r[title]</td>
                    </tr>
                    <tr>
                        <td class='col-2'>Text recenze:</td>
                        <td class='col-10'>$r[text]</td>
                    </tr>
                    <tr>
                        <td class='col-2'>Hodnocení:</td>
                        <td class='col-10'>$stars $r[rating]/100</td>
                    </tr>
                    </tbody>
                </table>
            </form>
        </div>
    </div>
</div>
        ";

    }
}
echo $res;

/**
 * Funkce pro vykreslení hvězd
 * @param int $rating Hodnocení
 * @return string HTML
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
