<?php

// šablona Správa uživatelů

// urceni globalnich promennych, se kterymi sablona pracuje
global $tplData;

$userInfo = "";
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
if ($tplData['showPage']) {
    if (isset($tplData['users'])) {

        // nastavení práva
        foreach ($tplData['users'] as $u) {
            $right = "";

            switch ($u['right']) {
                case 1:
                    $right = "
<select class='custom-select' name='right'>
    <option value='1' selected='selected'>nepřihlášený uživatel</option>
    <option value='2'>konzument</option>
    <option value='3'>správce</option>
    <option value='4'>administrátor</option>
</select>
                ";
                    break;
                case 2:
                    $right = "
<select class='custom-select' name='right'>
    <option value='1' >nepřihlášený uživatel</option>
    <option value='2' selected='selected'>konzument</option>
    <option value='3'>správce</option>
    <option value='4'>administrátor</option>
</select>
                ";
                    break;
                case 3:
                    $right = "
<select class='custom-select' name='right'>
    <option value='1' >nepřihlášený uživatel</option>
    <option value='2' >konzument</option>
    <option value='3' selected='selected'>správce</option>
    <option value='4'>administrátor</option>
</select>
                ";
                    break;
                case 4:
                    $right = "
<select class='custom-select' name='right'>
    <option value='1' >nepřihlášený uživatel</option>
    <option value='2' >konzument</option>
    <option value='3'>správce</option>
    <option value='4' selected='selected'>administrátor</option>
</select>
                ";
                    break;
                default:
                    $right = "Neznámý právo";
                    break;
            }

            // Výpis jednotlivých uživatelů
            $userInfo .= "
<tr>
    <td>$u[id_user]</td>
    <td>$u[login]</td>
    <td>$u[name]</td>
    <td>$u[email]</td>
    <td>
        <form method='post'>
            <input type='hidden' name='id_user' value='$u[id_user]'>
            <button type='submit' name='action' value='delete' class='btn btn-primary'>Smazat</button>
        </form>
    </td>
    <td>
        <form method='post'>
            $right
    </td>
    <td>
            <input type='hidden' name='id_user' value='$u[id_user]'>
            <button type='submit' name='action' value='changeRight' class='btn btn-primary'>Změna práva</button>
        </form>
    </td>
</tr>
        ";
        }
    }

    // Tabulka uživatelů
    $res .= "

<div class='container'>
<div class='jumbotron table-responsive'>
    <h2 class='text-center'>Tabulka uživatelů:</h2>
    <table class='table table-bordered table-secondary text-dark'>
        <thead>
        <tr>
            <th>ID</th>
            <th>Login</th>
            <th>Jméno</th>
            <th>Email</th>
            <th>Smazat</th>
            <th>Právo</th>
            <th>Akce</th>
        </tr>
        </thead>
        <tbody>
        $userInfo
        </tbody>
    </table>
    </div>
</div>
    ";
}

// Hláška pro nepřihlášeného uživatele
else {
    $res .= "
<div class='container'>
    <div class='alert alert-info'>
        <strong>Info!</strong> Jenom administrátor může spravovat uživatele.
    </div>
</div>
    ";
}


echo $res;