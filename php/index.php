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
    $id=(isset($_GET['id']))?$_GET['id']: "";
if(isset($_GET['action'])){
    
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

