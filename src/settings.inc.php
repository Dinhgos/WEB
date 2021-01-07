<?php
//////////////////////////////////////////////////////////////////
/////////////////  Globalni nastaveni aplikace ///////////////////
//////////////////////////////////////////////////////////////////
///

use kivweb\Controllers\AccountController;
use kivweb\Controllers\AllReviewsController;
use kivweb\Controllers\LoginController;
use kivweb\Controllers\ProductController;
use kivweb\Controllers\PrReviewController;
use kivweb\Controllers\RegisterController;
use kivweb\Controllers\ReviewController;
use kivweb\Controllers\UserManagementController;
use kivweb\Views\TemplateBased\TemplateBasics;

//// Pripojeni k databazi ////

/** Adresa serveru. */

define("DB_SERVER","localhost"); // https://students.kiv.zcu.cz lze 147.228.63.10, ale musite byt na VPN

/** Nazev databaze. */
define("DB_NAME","kivweb");

/** Uzivatel databaze. */
define("DB_USER","root");

/** Heslo uzivatele databaze */
define("DB_PASS","");

//// Nazvy tabulek v DB ////
define("TABLE_USER", "user");
define("TABLE_PRODUCT", "product");
define("TABLE_REVIEW", "review");
define("TABLE_RIGHT", "right");


//// Dostupne stranky webu ////

/** Klic defaultni webove stranky. */
const DEFAULT_WEB_PAGE_KEY = "product";

/** Dostupne webove stranky. */
const WEB_PAGES = array(

    // Stránka Produkty
    "product" => array(
        "title" => "Produkty",
        "controller_class_name" => ProductController::class,
        "view_class_name" => TemplateBasics::class,
        "template_type" => TemplateBasics::PAGE_PRODUCT,
    ),

    // Stránka Správa uživatelů
    "sprava" => array(
        "title" => "Správa uživatelů",
        "controller_class_name" => UserManagementController::class,
        "view_class_name" => TemplateBasics::class,
        "template_type" => TemplateBasics::PAGE_USER_MANAGEMENT,
    ),

    // Stránka Login
    "login" => array(
        "title" => "Login",
        "controller_class_name" => LoginController::class,
        "view_class_name" => TemplateBasics::class,
        "template_type" => TemplateBasics::PAGE_LOGIN,
    ),

    // Stránka Registrace
    "register" => array(
        "title" => "Registrace",
        "controller_class_name" => RegisterController::class,
        "view_class_name" => TemplateBasics::class,
        "template_type" => TemplateBasics::PAGE_REGISTER,
    ),

    // Stránka Účet
    "account" => array(
        "title" => "Účet",
        "controller_class_name" => AccountController::class,
        "view_class_name" => TemplateBasics::class,
        "template_type" => TemplateBasics::PAGE_ACCOUNT,
    ),

    // Stránka Recenze
    "review" => array(
        "title" => "Recenze",
        "controller_class_name" => ReviewController::class,
        "view_class_name" => TemplateBasics::class,
        "template_type" => TemplateBasics::PAGE_REVIEW,
    ),

    // Stránka Recenze produktu
    "prReview" => array(
    "title" => "Recenze produktu",
    "controller_class_name" => PrReviewController::class,
    "view_class_name" => TemplateBasics::class,
    "template_type" => TemplateBasics::PAGE_PRREVIEW,
    ),

    // Stránka Všechny recenze
    "allReviews" => array(
        "title" => "Všechny recenze",
        "controller_class_name" => AllReviewsController::class,
        "view_class_name" => TemplateBasics::class,
        "template_type" => TemplateBasics::PAGE_ALLREVIEWS,
    ),
);