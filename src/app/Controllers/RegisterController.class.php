<?php

namespace kivweb\Controllers;

use kivweb\Models\DatabaseModel as MyDB;

/**
 * Ovladac zajistujici vypsani stranky Registrace
 * Class RegisterController
 * @package kivweb\Controllers
 */
class RegisterController implements IController {

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
     * Vrati obsah stranky.
     * @param string $pageTitle     Nazev stranky.
     * @return array                Vytvorena data pro sablonu.
     */
    public function show(string $pageTitle): array {
        //// vsechna data sablony budou globalni
        $tplData = [];

        $tplData['title'] = $pageTitle;

        $tplData['isLoggedIn'] = $this->db->isUserLogged();

        // přihlášení uživatele
        if(isset($_POST['action'])){
            if ($_POST['action'] == 'register') {
                // mam vsechny pozadovane hodnoty?
                if(isset($_POST['login']) && isset($_POST['password1']) && isset($_POST['password2'])
                    && isset($_POST['name']) && isset($_POST['email'])
                    && $_POST['password1'] == $_POST['password2']
                    && $_POST['login'] != "" && $_POST['password1'] != "" && $_POST['name'] != "" && $_POST['email'] != ""
                ){
                    // mam vsechny atributy - ulozim uzivatele do DB
                    $res = $this->db->addNewUser($_POST['login'], $_POST['password1'], $_POST['name'], $_POST['email']);

                    // byl ulozen?
                    if($res){
                        $tplData['echo'] = "OK: Uživatel byl přidán do databáze.";
                        $this->db->userLogin($_POST['login'], $_POST['password1']);
                        echo "<meta http-equiv='refresh' content='0'>";
                    } else {
                        $tplData['echo'] = "ERROR: Uložení uživatele se nezdařilo.";
                    }
                } else {
                    // nemam vsechny atributy
                    $tplData['echo'] = "ERROR: Nebyly přijaty požadované atributy uživatele.";
                }
            } else {
                $tplData['echo'] = "WARNING: Neznámá akce.";
            }
        }

        return $tplData;
    }
}
