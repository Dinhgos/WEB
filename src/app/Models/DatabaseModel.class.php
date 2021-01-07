<?php

namespace kivweb\Models;

use kivweb\Controllers\MySession;
use PDO;
use PDOStatement;

/**
 * Trida spravujici databazi.
 * @package kivweb\Models
 */
class DatabaseModel {

    /** @var DatabaseModel $database  Singleton databazoveho modelu. */
    private static $database;

    /** @var PDO $pdo  Objekt pracujici s databazi prostrednictvim PDO. */
    private $pdo;
    /** @var MySession $mySession  Vlastni objekt pro spravu session. */
    private $mySession;
    /** @var string $userSessionKey  Klicem pro data uzivatele, ktera jsou ulozena v session. */
    private $userSessionKey = "current_user_id";

    /**
     * Inicializace pripojeni k databazi.
     */
    private function __construct() {
        // inicializace DB
        $this->pdo = new PDO("mysql:host=".DB_SERVER.";dbname=".DB_NAME, DB_USER, DB_PASS);
        // vynuceni kodovani UTF-8
        $this->pdo->exec("set names utf8");

        $this->mySession = new MySession();
    }

    /**
     * Tovarni metoda pro poskytnuti singletonu databazoveho modelu.
     * @return DatabaseModel    Databazovy model.
     */
    public static function getDatabaseModel(): DatabaseModel {
        if(empty(self::$database)){
            self::$database = new DatabaseModel();
        }
        return self::$database;
    }


    //////////////////////////////////////////////////////////
    ///////////  Prace s databazi  /////////////////////////
    //////////////////////////////////////////////////////////

    /**
     *  Provede dotaz a bud vrati ziskana data, nebo pri chybe ji vypise a vrati null.
     *
     *  @param string $dotaz        SQL dotaz.
     *  @return PDOStatement    Vysledek dotazu.
     */
    private function executeQuery(string $dotaz) {
        // vykonam dotaz
        $res = $this->pdo->query($dotaz);
        // pokud neni false, tak vratim vysledek, jinak null
        if ($res) {
            // neni false
            return $res;
        } else {
            // je false - vypisu prislusnou chybu a vratim null
            $error = $this->pdo->errorInfo();
            echo $error[2];
            return null;
        }
    }

    /**
     * Jednoduche cteni z prislusne DB tabulky.
     *
     * @param string $tableName Nazev tabulky.
     * @param string $whereStatement Pripadne omezeni na ziskani radek tabulky. Default "".
     * @param string $orderByStatement Řazení
     * @return array                    Vraci pole ziskanych radek tabulky.
     */
    public function selectFromTable(string $tableName, string $whereStatement = "", string $orderByStatement = ""):array {
        // slozim dotaz
        $q = "SELECT * FROM ".$tableName
            .(($whereStatement == "") ? "" : " WHERE $whereStatement")
            .(($orderByStatement == "") ? "" : " ORDER BY $orderByStatement");

        // provedu ho a vratim vysledek
        $obj = $this->executeQuery($q);
        // pokud je null, tak vratim prazdne pole
        if($obj == null){
            return [];
        }

        // prevedu vsechny ziskane radky tabulky na pole
        return $obj->fetchAll();
    }

    /**
     * Jednoduchy zapis do prislusne tabulky.
     *
     * @param string $tableName         Nazev tabulky.
     * @param string $insertStatement   Text s nazvy sloupcu pro insert.
     * @param string $insertValues      Text s hodnotami pro prislusne sloupce.
     * @return bool                     Vlozeno v poradku?
     */
    public function insertIntoTable(string $tableName, string $insertStatement, string $insertValues):bool {
        $insertStatement = htmlspecialchars($insertStatement);
        $insertValues = htmlspecialchars($insertValues);

        // slozim dotaz
        $q = "INSERT INTO $tableName($insertStatement) VALUES ($insertValues)";

        $obj = $this->executeQuery($q);
        if($obj == null){
            return false;
        } else {
            return true;
        }
    }

    /**
     * Jednoducha uprava radku databazove tabulky.
     *
     * @param string $tableName                     Nazev tabulky.
     * @param string $updateStatementWithValues     Cela cast updatu s hodnotami.
     * @param string $whereStatement                Cela cast pro WHERE.
     * @return bool                                 Upraveno v poradku?
     */
    public function updateInTable(string $tableName, string $updateStatementWithValues, string $whereStatement):bool {
        $updateStatementWithValues = htmlspecialchars($updateStatementWithValues);
        $whereStatement = htmlspecialchars($whereStatement);

        // slozim dotaz
        $q = "UPDATE $tableName SET $updateStatementWithValues WHERE $whereStatement";

        // provedu ho a vratim vysledek
        $obj = $this->executeQuery($q);
        if($obj == null){
            return false;
        } else {
            return true;
        }
    }

    /**
     * Dle zadane podminky maze radky v prislusne tabulce.
     *
     * @param string $tableName Nazev tabulky.
     * @param string $whereStatement Podminka mazani.
     * @return bool
     */
    public function deleteFromTable(string $tableName, string $whereStatement): bool {
        // slozim dotaz
        $q = "DELETE FROM $tableName WHERE $whereStatement";
        // provedu ho a vratim vysledek
        $obj = $this->executeQuery($q);
        if($obj == null){
            return false;
        } else {
            return true;
        }
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////// Práce s Databází

    /**
     * Vybere uživatele podle ID
     * @param int $id_user id uživatele
     * @return array informace o uživateli
     */
    public function getUsersReviews(int $id_user):array {
        $id_user = htmlspecialchars($id_user);

        $where = "id_user=".$id_user;

        return $this->selectFromTable(TABLE_REVIEW,$where);
    }

    /**
     * Nastaví viditelnost recenzí
     * @param int $bool viditelnost
     * @param int $idUser id recenze
     * @return bool ok = TRUE / chyba = FALSE
     */
    public function updateVisibility(int $bool, int $idUser):bool {
        $bool = htmlspecialchars($bool);
        $idUser = htmlspecialchars($idUser);

        $value = $bool == 1 ? '1':'0';
        $set = "hidden=".$value;
        $where = "id_review=".$idUser;

        return $this->updateInTable(TABLE_REVIEW,$set,$where);
    }

    /**
     * Přidá recenzi
     * @param int $product id produktu
     * @param int $id_user id uživatele
     * @param int $sel1 hodnocení
     * @param string $title nadpis
     * @param string $comment text recenze
     * @return bool ok = TRUE / chyba = FALSE
     */
    public function addReview(int $product,int $id_user, int $sel1, string $title, string $comment): bool {
        $product = htmlspecialchars($product);
        $id_user = htmlspecialchars($id_user);
        $sel1 = htmlspecialchars($sel1);
        $title = htmlspecialchars($title);
        $comment = htmlspecialchars($comment);

        $hidden = 0;
        $insertStatement = "id_user, id_product, rating, title, text, hidden";
        $insertValues = "$id_user, $product, $sel1, '$title', '$comment',$hidden";

        return $this->insertIntoTable(TABLE_REVIEW, $insertStatement, $insertValues);
    }

    /**
     * Najde recenzi pomocí id produktu
     * @param int $id_product id produktu
     * @return array informace o produktu
     */
    public function getReviewByProduct(int $id_product): array {
        $id_product = htmlspecialchars($id_product);

        $whereStatement = "id_product=".$id_product." AND hidden = 0";

        return $this->selectFromTable(TABLE_REVIEW,$whereStatement);
    }

    /**
     * Změna práva
     * @param int $id_user id uživatele
     * @param int $right právo
     * @return bool ok = TRUE / chyba = FALSE
     */
    public function changeUsersRight(int $id_user, int $right):bool {
        $id_user = htmlspecialchars($id_user);
        $right = htmlspecialchars($right);

        $set = "`right` = ".$right;
        $where = "`id_user` = ".$id_user;

        return $this->updateInTable(TABLE_USER,$set,$where);
    }

    /**
     * přidá produkt
     * @param string $name název produktu
     * @param int $price cena
     * @param string $description popis produktu
     * @return bool ok = TRUE / chyba = FALSE
     */
    public function addProduct(string $name, int $price, string $description): bool {
        $name = htmlspecialchars($name);
        $price = htmlspecialchars($price);
        $description = htmlspecialchars($description);

        $insertStatement = "name, price, description";
        $insertValues = "'$name', $price, '$description'";

        return $this->insertIntoTable(TABLE_PRODUCT, $insertStatement, $insertValues);
    }

    /**
     * Vymazání produktu
     * @param int $id_product id produktu
     * @return bool ok = TRUE / chyba = FALSE
     */
    public function deleteProduct(int $id_product): bool {
        $id_product = htmlspecialchars($id_product);

        $whereStatement = "id_product=$id_product";

        // smaže všechny recenze produktu
        $reviews = $this->getReviewByProduct($id_product);
        while (!empty($reviews)) {
            $reviews = $this->getReviewByProduct($id_product);
            $this->deleteReviewProduct($id_product);
        }

        return $this->deleteFromTable(TABLE_PRODUCT,$whereStatement);
    }

    /**
     * Vymazání recenzí pomocí id produktu
     * @param int $id_product id produktu
     * @return bool ok = TRUE / chyba = FALSE
     */
    public function deleteReviewProduct(int $id_product): bool {
        $id_product = htmlspecialchars($id_product);

        $whereStatement = "id_product=$id_product";

        return $this->deleteFromTable(TABLE_REVIEW,$whereStatement);
    }

    /**
     * Smaze daneho uzivatele z DB.
     * @param int $userId ID uzivatele.
     * @return bool ok = TRUE / chyba = FALSE
     */
    public function deleteUser(int $userId):bool {
        $whereStatement = "id_user=$userId";

        // smaže všechny recenze
        $reviews = $this->getUsersReviews($userId);
        while (!empty($reviews)) {
            $reviews = $this->getUsersReviews($userId);
            $this->deleteReviewUser($userId);
        }

        return $this->deleteFromTable(TABLE_USER,$whereStatement);
    }

    /**
     * Smaže recenze pomocí id uživatele
     * @param int $userId id uživatele
     * @return bool ok = TRUE / chyba = FALSE
     */
    public function deleteReviewUser(int $userId): bool {
        $userId = htmlspecialchars($userId);

        $whereStatement = "id_user=$userId";

        return $this->deleteFromTable(TABLE_REVIEW,$whereStatement);
    }
    
    /**
     *  Vrati seznam vsech uzivatelu pro spravu uzivatelu.
     *  @return array Obsah spravy uzivatelu.
     */
    public function getAllUsers():array {
        return $this->selectFromTable(TABLE_USER);
    }

    /**
     * Najde uživatele pomocí id
     * @param int $id id uživatele
     * @return array Informace o uživateli
     */
    public function getUserById(int $id): array{
        $id = htmlspecialchars($id);

        // ziskam uzivatele dle ID
        return $this->selectFromTable(TABLE_USER, "id_user=$id");
    }

    /**
     * Seznam všech produktů
     * @return array Seznam všech produktů
     */
    public function getAllProducts():array {
        return $this->selectFromTable(TABLE_PRODUCT);
    }

    /**
     * Seznam všech recenzí
     * @return array Seznam všech recenzí
     */
    public function getAllReviews():array {
        return $this->selectFromTable(TABLE_REVIEW);
    }

    /**
     * Vytvoreni noveho uzivatele v databazi.
     *
     * @param string $login Login.
     * @param string $heslo Heslo
     * @param string $jmeno Jmeno.
     * @param string $email E-mail.
     * @return bool             Vlozen v poradku?
     */
    public function addNewUser(string $login, string $heslo, string $jmeno, string $email): bool {
        $login = htmlspecialchars($login);
        $heslo = htmlspecialchars($heslo);
        $jmeno = htmlspecialchars($jmeno);
        $email = htmlspecialchars($email);

        $duplicatedLogin = false;

        // hlavicka pro vlozeni do tabulky uzivatelu
        $insertStatement = "`right`, `login`, `password`, `name`, `email`";

        // hodnoty pro vlozeni do tabulky uzivatelu
        $right = 1;
        $insertValues = "'$right', '$login', '$heslo', '$jmeno', '$email'";
        $table = "`user`";

        $users = $this->getAllUsers();

        foreach ($users as $u) {
            if ($u['login'] == $login) {
                $duplicatedLogin = true;
            }
        }

        if (!$duplicatedLogin) {
            // provedu dotaz a vratim jeho vysledek
            return $this->insertIntoTable($table, $insertStatement, $insertValues);
        }

        return false;
    }

    //////////////////////////////////////////////////////////
    ///////////  KONEC: Prace s databazi  /////////////////////////
    //////////////////////////////////////////////////////////


    ///////////////////  Sprava prihlaseni uzivatele  ////////////////////////////////////////

    /**
     * Overi, zda muse byt uzivatel prihlasen a pripadne ho prihlasi.
     *
     * @param string $login     Login uzivatele.
     * @param string $heslo     Heslo uzivatele.
     * @return bool             Byl prihlasen?
     */
    public function userLogin(string $login, string $heslo): bool {
        $login = htmlspecialchars($login);
        $heslo = htmlspecialchars($heslo);

        // ziskam uzivatele z DB - primo overuju login i heslo
        $where = "login='$login' AND password='$heslo'";
        $user = $this->selectFromTable(TABLE_USER, $where);
        // ziskal jsem uzivatele
        if(count($user)){
            // ziskal - ulozim ho do session
            $_SESSION[$this->userSessionKey] = $user[0]['id_user']; // beru prvniho nalezeneho a ukladam jen jeho ID
            return true;
        } else {
            // neziskal jsem uzivatele
            return false;
        }
    }

    /**
     * Odhlasi soucasneho uzivatele.
     */
    public function userLogout(){
        unset($_SESSION[$this->userSessionKey]);
    }

    /**
     * Test, zda je nyni uzivatel prihlasen.
     *
     * @return bool     Je prihlasen?
     */
    public function isUserLogged(): bool {
        return isset($_SESSION[$this->userSessionKey]);
    }

    /**
     * Pokud je uzivatel prihlasen, tak vrati jeho data,
     * ale pokud nebyla v session nalezena, tak vypisu chybu.
     *
     * @return mixed|null   Data uzivatele nebo null.
     */
    public function getLoggedUserData(){
        if($this->isUserLogged()){
            // ziskam data uzivatele ze session
            $userId = $_SESSION[$this->userSessionKey];
            // pokud nemam data uzivatele, tak vypisu chybu a vynutim odhlaseni uzivatele
            if($userId == null) {
                // nemam data uzivatele ze session - vypisu jen chybu, uzivatele odhlasim a vratim null
                echo "SEVER ERROR: Data přihlášeného uživatele nebyla nalezena, a proto byl uživatel odhlášen.";
                $this->userLogout();
                // vracim null
                return null;
            } else {
                // nactu data uzivatele z databaze
                $userData = $this->selectFromTable(TABLE_USER, "id_user=$userId");
                // mam data uzivatele?
                if(empty($userData)){
                    // nemam - vypisu jen chybu, uzivatele odhlasim a vratim null
                    echo "ERROR: Data přihlášeného uživatele se nenachází v databázi (mohl být smazán), a proto byl uživatel odhlášen.";
                    $this->userLogout();
                    return null;
                } else {
                    // protoze DB vraci pole uzivatelu, tak vyjmu jeho prvni polozku a vratim ziskana data uzivatele
                    return $userData[0];
                }
            }
        } else {
            // uzivatel neni prihlasen - vracim null
            return null;
        }
    }

    /**
     * Uprava konkretniho uzivatele v databazi.
     *
     * @param int $idUzivatel   ID upravovaneho uzivatele.
     * @param string $login     Login.
     * @param string $heslo     Heslo.
     * @param string $jmeno     Jmeno.
     * @param string $email     E-mail.
     * @return bool             Bylo upraveno?
     */
    public function updateUser(int $idUzivatel, string $login, string $heslo, string $jmeno, string $email): bool {
        $idUzivatel = htmlspecialchars($idUzivatel);
        $login = htmlspecialchars($login);
        $heslo = htmlspecialchars($heslo);
        $jmeno = htmlspecialchars($jmeno);
        $email = htmlspecialchars($email);

        // slozim cast s hodnotami
        $updateStatementWithValues = "login='$login', password='$heslo', name='$jmeno', email='$email'";
        // podminka
        $whereStatement = "id_user=$idUzivatel";
        // provedu update
        return $this->updateInTable(TABLE_USER, $updateStatementWithValues, $whereStatement);
    }

    ///////////////////  KONEC: Sprava prihlaseni uzivatele  ////////////////////////////////////////
}
