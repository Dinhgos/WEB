<?php

namespace kivweb\Controllers;

use kivweb\Models\DatabaseModel as MyDB;

/**
 * Ovladac zajistujici vypsani stranky Produkty
 * @package kivweb\Controllers
 */
class ProductController implements IController {

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
    public function show(string $pageTitle):array {
        //// vsechna data sablony budou globalni
        $tplData = [];

        $tplData['isLoggedIn'] = $this->db->isUserLogged();

        // nazev
        $tplData['title'] = $pageTitle;

        $tplData['product'] = $this->db->getAllProducts();

        // je uživatel přihlášen
        if ($tplData['isLoggedIn']) {
            $user = $this->db->getLoggedUserData();
            $tplData['right'] = $user['right'];

            // má právo
            if ($user['right'] > 3) {
                $tplData['showAdmin'] = true;
                $tplData['products'] = $this->db->getAllProducts();
            }
            else {
                $tplData['showAdmin'] = false;
            }
        } else {
            $tplData['showAdmin'] = false;
        }

        // přidá produkt do databáze
        if (isset($_POST['addProduct'])) {
            if (isset($_POST['name']) && isset($_POST['price']) && isset($_POST['description'])
            && $_POST['name'] != "" && $_POST['price'] != "" && $_POST['description'] != "" && $_POST['price'] >=0
            ) {

                $ok = $this->db->addProduct($_POST['name'],$_POST['price'],$_POST['description']);

                if($ok){
                    $tplData['echo'] = "Produkt byl přidán do databáze.";
                } else {
                    $tplData['echo'] = "Nepodařilo se přidat produkt do databáze.";
                }
            }
            else {
                $tplData['echo'] = "Nebyly přijaty požadované atributy produktu.";
            }
        }

        // smaže produkt
        if(isset($_POST['action']) and $_POST['action'] == "delete"
            and isset($_POST['id_product'])
        ){
            // provedu smazani uzivatele
            $ok = $this->db->deleteProduct($_POST['id_product']);
            if($ok){
                $tplData['echo'] = "Produkt s ID: $_POST[id_product] byl smazán z databáze.";
                echo "<meta http-equiv='refresh' content='0'>";
            } else {
                $tplData['echo'] = "Produkt s ID: $_POST[id_product] se nepodařilo smazat z databáze.";
            }
        }

        return $tplData;
    }
}

