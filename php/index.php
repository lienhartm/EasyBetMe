<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'includes/config.inc.php';

require_once "controleur/HomeControlleur.php";

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

