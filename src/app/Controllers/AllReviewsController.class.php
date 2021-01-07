<?php

namespace kivweb\Controllers;

// ukazka aliasu
use kivweb\Models\DatabaseModel as MyDB;

/**
 * Ovladac zajistujici vypsani stranky se spravou uzivatelu.
 * @package kivweb\Controllers
 */
class AllReviewsController implements IController {

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


        if ($tplData['isLoggedIn']) {
            $user = $this->db->getLoggedUserData();
            $tplData['right'] = $user['right'];
            $tplData['reviews'] = $this->db->getAllReviews();
        }

        // nastaví viditelnost
        if (isset($_POST['vis'])) {
            switch ($_POST['vis']) {
                case 0:
                    $res = $this->db->updateVisibility(1,$_POST['idRev']);
                    if($res){
                        $tplData['echo'] = "Recenze byla upravena.";
                        echo "<meta http-equiv='refresh' content='0'>";
                    } else {
                        $tplData['echo'] = "Upravení se nezdařilo.";
                    }
                    break;
                case 1:
                    $res = $this->db->updateVisibility(0,$_POST['idRev']);
                    if($res){
                        $tplData['echo'] = "OK: Recenze byla upravena.";
                        echo "<meta http-equiv='refresh' content='0'>";
                    } else {
                        $tplData['echo'] = "Upravení se nezdařilo.";
                    }

                    break;
                default:
                    $tplData['echo'] = "Nepodařilo se změnit viditelnost.";
                    break;
            }
        }

        return $tplData;
    }
}