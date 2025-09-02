<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'includes/config.inc.php';

require_once "controleur/AdminControlleur.php";
require_once "controleur/AideControlleur.php";
require_once "controleur/GiftControlleur.php";
require_once "controleur/HomeControlleur.php";
require_once "controleur/InfoControlleur.php";
require_once "controleur/LoginControlleur.php";
require_once "controleur/NewsControlleur.php";
require_once "controleur/PenaltyControlleur.php";
require_once "controleur/ProfilControlleur.php";

$ctrlHome = new HomeControlleur();

if(isset($_GET['action'])){
    $action = $_GET['action'];
    $id=(isset($_GET['id']))?$_GET['id']: "";
    switch($action){
        case "login":
            $ctrlLogin = new LoginControlleur();
            $ctrlLogin->loginPage();
            break;
        case "logout":
            $ctrlLogin = new LoginControlleur();
            $ctrlLogin->logout();
            break;
        case "profile":
            $ctrlProfil = new ProfilControlleur();
            $ctrlProfil->profilPage();
            break;
        case "admin":
            $ctrlAdmin = new AdminControlleur();
            $ctrlAdmin->adminPage();
            break;
        case "gift":
            $ctrlGift = new GiftControlleur();
            $ctrlGift->giftPage();
            break;
        case "penalty":
            $ctrlPenalty = new PenaltyControlleur();
            $ctrlPenalty->penaltyPage();
            break;
        case "news":
            $ctrlNews = new NewsControlleur();
            $ctrlNews->newsPage($id);
            break;
        case "info":
            $ctrlInfo = new InfoControlleur();
            $ctrlInfo->infoPage($id);
            break;
        case "aide":
            $ctrlAide = new AideControlleur();
            $ctrlAide->aidePage();
            break;
        default:
            $ctrlHome->homePage();
    }
} else {	
    $ctrlHome->homePage();
}

/*
$pdo = new BD();

$requete = "SELECT * FROM easybet_users";

$user = $pdo->executeRequest($requete);
$users = $user->fetchAll(PDO::FETCH_ASSOC);

// Affichage des résultats
echo '<pre>';
print_r($users);
echo '</pre>';
*/

?>

