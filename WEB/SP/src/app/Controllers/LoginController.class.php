<?php

namespace kivweb\Controllers;

use kivweb\Models\DatabaseModel as MyDB;

/**
 * Ovladac zajistujici vypsani stranky LOgin
 * Class LoginController
 * @package kivweb\Controllers
 */
class LoginController implements IController {

    /** @var MyDB $db  Sprava databaze. */
    private $db;

    /**
     * Inicializace pripojeni k databazi.
     */
    public function __construct() {
        // inicializace prace s DB
        $this->db = MyDB::getDatabaseModel();
    }

    /**
     * Vrati obsah stranky
     * @param string $pageTitle     Nazev stranky.
     * @return array                Vytvorena data pro sablonu.
     */
    public function show(string $pageTitle): array {
        //// vsechna data sablony budou globalni
        $tplData = [];

        $user = NULL;
        // nazev
        $tplData['title'] = $pageTitle;

        $tplData['isLoggedIn'] = $this->db->isUserLogged();

        // je uživatel přihlášen
        if ($tplData['isLoggedIn']) {
            $user = $this->db->getLoggedUserData();
            $tplData['users'] = $this->db->getUserById($user['id_user']);
        }

        if(isset($_POST['action'])){
            // prihlaseni
            if($_POST['action'] == 'login' && isset($_POST['login']) && isset($_POST['heslo'])){
                // pokusim se prihlasit uzivatele
                $res = $this->db->userLogin($_POST['login'], $_POST['heslo']);

                if($res){
                    $tplData['echo'] = "OK: Uživatel byl přihlášen.";
                    echo "<meta http-equiv='refresh' content='0'>";
                } else {
                    $tplData['echo'] = "ERROR: Přihlášení uživatele se nezdařilo.";
                }
            }
            // odhlaseni
            else if($_POST['action'] == 'logout'){
                // odhlasim uzivatele
                $this->db->userLogout();
                $tplData['echo'] = "OK: Uživatel byl odhlášen.";
                echo "<meta http-equiv='refresh' content='0'>";
            }
            // neznama akce
            else {
                $tplData['echo'] = "Neznámá akce.";
            }
        }

        return $tplData;
    }
}