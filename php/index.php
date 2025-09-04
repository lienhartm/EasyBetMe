<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'includes/config.inc.php';

require_once "controleur/AdminControlleur.php";
require_once "controleur/BetControlleur.php";
require_once "controleur/DataControlleur.php";
//require_once "controleur/EventControlleur.php";
require_once "controleur/GamerControlleur.php";
require_once "controleur/GiftControlleur.php";
require_once "controleur/HomeControlleur.php";
require_once "controleur/InfoControlleur.php";
require_once "controleur/LoginControlleur.php";
require_once "controleur/NewsControlleur.php";
require_once "controleur/PenaltyControlleur.php";
require_once "controleur/ProfilControlleur.php";
//require_once "controleur/UserControlleur.php";

$ctrlAdmin = new AdminControlleur();
//$ctrlBet = new BetControlleur();
$ctrlData = new DataControlleur();
//$ctrlEvent = new EventControlleur();
$ctrlGamer = new GamerControlleur();
$ctrlGift = new GiftControlleur();
$ctrlHome = new HomeControlleur();
$ctrlInfo = new InfoControlleur();
$ctrlLogin = new LoginControlleur();
$ctrlNews = new NewsControlleur();
$ctrlPenalty = new PenaltyControlleur();
$ctrlProfil = new ProfilControlleur();
//$ctrlUser = new UserControlleur();

if(isset($_GET['competition'])){
    $competition = $_GET['competition'];
}
if(isset($_GET['action'])){
    $action = $_GET['action'];
    $id=(isset($_GET['id']))?$_GET['id']: "";
    switch($action){
        case "login":
            $ctrlLogin->loginPage();
            break;
        case "logout":
            $ctrlLogin->logout();
            break;
        case "profile":
            $ctrlProfil->profilPage();
            break;
        case "admin":
            $ctrlAdmin->adminPage();
            break;
        case "gift":
            $ctrlGift->giftPage();
            break;
        case "penalty":
            $ctrlPenalty->penaltyPage();
            break;
        case "news":
            $ctrlNews->newsPage();
            break;
        case "infos":
            $ctrlInfo->infoPage($competition);
            break;
        case "aide":
            $ctrlHome->aidePage();
            break;
        default:
            $ctrlHome->homePage();
    }
} else {	
    $ctrlHome->homePage();
}

?>

