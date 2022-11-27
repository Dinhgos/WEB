<?php

namespace kivweb\Controllers;

use kivweb\Models\DatabaseModel as MyDB;

/**
 * Ovladac zajistujici vypsani stranky Recenze produktu
 * @package kivweb\Controllers
 */
class PrReviewController implements IController {

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

        // nazev
        $tplData['title'] = $pageTitle;

        // recenze produktu
        if (isset($_POST['id_product']) && $_POST['id_product'] != "") {
            $tplData['reviews'] = $this->db->getReviewByProduct($_POST['id_product']);
        }

        return $tplData;
    }
}

