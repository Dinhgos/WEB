<?php

namespace kivweb\Controllers;

use kivweb\Models\DatabaseModel as MyDB;

/**
 * Ovladac zajistujici vypsani stranky se spravou uzivatelu.
 * @package kivweb\Controllers
 */
class UserManagementController implements IController {

    /** @var MyDB $db  Sprava databaze. */
    private $db;

    /**
     * Inicializace pripojeni k databazi.
     */
    public function __construct() {
        // inicializace prace s DB
        //require_once (DIRECTORY_MODELS ."/DatabaseModel.class.php");
        $this->db = MyDB::getDatabaseModel();
    }

    /**
     * Vrati obsah stranky se spravou uzivatelu.
     * @param string $pageTitle     Nazev stranky.
     * @return array                Vytvorena data pro sablonu.
     */
    public function show(string $pageTitle):array {
        //// vsechna data sablony budou globalni
        $tplData = [];
        // nazev
        $tplData['title'] = $pageTitle;

        $tplData['isLoggedIn'] = $this->db->isUserLogged();

        // je uživatel prihlášen
        if ($tplData['isLoggedIn']) {
            $user = $this->db->getLoggedUserData();

            // má právo
            if ($user['right'] > 3) {
                $tplData['showPage'] = true;
            }
            else {
                $tplData['showPage'] = false;
            }
        } else {
            $tplData['showPage'] = false;
        }

        //// neprisel pozadavek na smazani uzivatele?
        if(isset($_POST['action']) and $_POST['action'] == "delete"
            and isset($_POST['id_user'])
        ){
            // provedu smazani uzivatele
            $ok = $this->db->deleteUser(intval($_POST['id_user']));
            if($ok){
                $tplData['echo'] = "Uživatel s ID: $_POST[id_user] byl smazán z databáze.";
            } else {
                $tplData['echo'] = "CHYBA: Uživatele s ID:$_POST[id_user] se nepodařilo smazat z databáze.";
            }
        }

        // změna práva
        if(isset($_POST['action']) and $_POST['action'] == "changeRight"
            and isset($_POST['right']) && isset($_POST['id_user'])
        ){
            $ok = $this->db->changeUsersRight($_POST['id_user'],$_POST['right']);

            if($ok){
                $tplData['echo'] = "Uživateli s ID: $_POST[id_user] byl bylo změněno právo.";
            } else {
                $tplData['echo'] = "Uživatele s ID:$_POST[id_user] se nepodařilo změnit právo.";
            }
        }

        //// nactu aktualni data uzivatelu
        $tplData['users'] = $this->db->getAllUsers();

        // vratim sablonu naplnenou daty
        return $tplData;
    }
}
