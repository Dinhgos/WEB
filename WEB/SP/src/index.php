<?php

// nactu funkci vlastniho autoloaderu trid
use kivweb\ApplicationStart;

require_once("myAutoloader.inc.php");

// nactu vlastni nastaveni webu
require_once("settings.inc.php");

// spustim aplikaci
$app = new ApplicationStart();
$app->appStart();