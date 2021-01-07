<?php

namespace kivweb\Controllers;

use kivweb\Models\DatabaseModel as MyDB;

/**
 * Ovladac zajistujici vypsani stranky Recenze
 * Class RegisterController
 * @package kivweb\Controllers
 */
class ReviewController implements IController {

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

        // Id produktu
        if (isset($_POST['id_product'])) {
            $tplData['id_product'] = $_POST['id_product'];
        } else {
            $tplData['echo'] = "id_product nenalezena";
        }

        // Přidáni recenze
        if(isset($_POST['send'])){
            if (isset($_POST['title']) && isset($_POST['comment']) && isset($_POST['sellist1'])
            && $_POST['title'] != "" && $_POST['comment'] != "" && $_POST['sellist1'] != ""
            && $_POST['id_product'] && isset($_POST['id_product'])
        ){
                $user = $this->db->getLoggedUserData();
                $res = $this->db->addReview($_POST['id_product'],$user['id_user'],$_POST['sellist1'],$_POST['title'],$_POST['comment']);

                if($res){
                    $tplData['echo'] = "Recenze byla přidána do databáze.";

                } else {
                    $tplData['echo'] = "Uložení se nezdařilo.";
                }
            } else {
                $tplData['echo'] = "Wrong inputs.";
            }
        }
        return $tplData;
    }
}
