<?php

namespace kivweb\Views\TemplateBased;

use kivweb\Views\IView;

/**
 * Trida vypisujici HTML hlavicku a paticku stranky.
 * @package kivweb\Views\TemplateBased
 */
class TemplateBasics implements IView {

    // šablony stránek
    const PAGE_USER_MANAGEMENT = "UserManagementTemplate.tpl.php";
    const PAGE_PRODUCT = "ProductTemplate.tpl.php";
    const PAGE_ACCOUNT = "AccountTemplate.tpl.php";
    const PAGE_REGISTER = "RegisterTemplate.tpl.php";
    const PAGE_LOGIN = "LoginTemplate.tpl.php";
    const PAGE_REVIEW = "ReviewTemplate.tpl.php";
    const PAGE_PRREVIEW = "PrReviewTemplate.tpl.php";
    const PAGE_ALLREVIEWS = "AllReviewsTemplate.tpl.php";

    /**
     * Zajisti vypsani HTML sablony prislusne stranky.
     * @param array $templateData       Data stranky.
     * @param string $pageType          Typ vypisovane stranky.
     */
    public function printOutput(array $templateData, string $pageType = self::PAGE_PRODUCT) {
        //// vypis hlavicky
        $this->getHTMLHeader($templateData['title']);

        //// vypis sablony obsahu
        // data pro sablonu nastavim globalni
        global $tplData;
        $tplData = $templateData;
        // nactu sablonu
        require_once($pageType);

        //// vypis pacicky
        $this->getHTMLFooter();
    }


    /**
     *  Vrati vrsek stranky az po oblast, ve ktere se vypisuje obsah stranky.
     *  @param string $pageTitle    Nazev stranky.
     */
    public function getHTMLHeader(string $pageTitle) {
        ?>

        <!doctype html>
        <html lang="cs">

        <head>
            <meta charset='utf-8'>
            <title><?php echo $pageTitle; ?></title>

            <!--Bootstrap-->
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        </head>

        <body>

        <!-- nadpis stránky -->
        <h1 class="container-fluid">Stránka: <?php echo $pageTitle; ?></h1>

        <!-- navbar-->
        <nav class="navbar navbar-expand-md bg-dark navbar-dark sticky-top">

            <!-- Menu -->
            <a class="navbar-brand" href="#">
                <i class="fas fa-bars"></i>
                Menu
            </a>

            <!-- Toggler/collapsibe Button -->
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Navbar links -->
            <div class="collapse navbar-collapse" id="collapsibleNavbar">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="http://localhost/WEB/SP/src/index.php?page=product">Produkty</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="http://localhost/WEB/SP/src/index.php?page=login">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="http://localhost/WEB/SP/src/index.php?page=register">Registrace</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="http://localhost/WEB/SP/src/index.php?page=account">Účet</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="http://localhost/WEB/SP/src/index.php?page=allReviews">Správa recenzí</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="http://localhost/WEB/SP/src/index.php?page=sprava">Správa uživatelů</a>
                    </li>
                </ul>
            </div>
        </nav>
        <br>
        <?php
    }
    
    /**
     *  Vrati paticku stranky.
     */
    public function getHTMLFooter(){
        ?>
        <footer class="footer">
            <div class="text-center p-3" style="background-color: rgb(52, 58, 64)">
                <a class="text-light" href="https://portal.zcu.cz/portal/studium/courseware/kiv/web/samostatna-prace/index.html">Samostatná práce z KIW/WEB</a>
            </div>
        </footer>

        <?php
    }
}

?>
