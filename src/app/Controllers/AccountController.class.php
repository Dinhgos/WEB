<?php

namespace kivweb\Controllers;

// ukazka aliasu
use kivweb\Models\DatabaseModel as MyDB;

/**
 * Ovladac zajistujici vypsani stranky se spravou uzivatelu.
 * @package kivweb\Controllers
 */
class AccountController implements IController {

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
        $user = [];
        // nazev
        $tplData['title'] = $pageTitle;

        if ($this->db->isUserLogged()) {
            $user = $this->db->getLoggedUserData();
            $tplData['userData'] = $this->db->getUserById($user['id_user']);
            $tplData['reviews'] = $this->db->getUsersReviews($user['id_user']);
        }

        if(isset($_POST['action'])){
            // mam vsechny pozadovane hodnoty?
            if(isset($_POST['id_uzivatel']) && isset($_POST['heslo']) && isset($_POST['heslo2'])
                && isset($_POST['jmeno']) && isset($_POST['email'])
                && $_POST['heslo'] == $_POST['heslo2']
                && $_POST['heslo'] != "" && $_POST['jmeno'] != "" && $_POST['email'] != ""
                // je soucasnym uzivatelem a zadal spravne heslo?
                && $_POST['id_uzivatel'] == $user['id_user']
            ){
                // bylo zadano sprevne soucasne heslo?
                if($_POST['heslo_puvodni'] == $user['password']){
                    // bylo a mam vsechny atributy - ulozim uzivatele do DB
                    $res = $this->db->updateUser($user['id_user'], $user['login'], $_POST['heslo'], $_POST['jmeno'], $_POST['email']);
                    // byl ulozen?
                    if($res){
                        $tplData['echo'] = "OK: Uživatel byl upraven.";
                        echo "<meta http-equiv='refresh' content='0'>";
                    } else {
                        $tplData['echo'] = "Upravení uživatele se nezdařilo.";
                    }
                } else {
                    // nebylo
                    $tplData['echo'] = "Zadané současné heslo uživatele není správné.";
                }
            } else {
                // nemam vsechny atributy
                $tplData['echo'] = "Nebyly přijaty požadované atributy uživatele.";
            }
        }

        // nastaví viditelnost
        if (isset($_POST['vis'])) {
            switch ($_POST['vis']) {
                case 0:
                    $res = $this->db->updateVisibility(1,$_POST['idRev']);
                    if($res){
                        $tplData['echo'] = "OK: Recenze byla upravena.";
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
?>
