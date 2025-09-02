<?
$Retour = null;
if($_SESSION['activate']==1) $Retour=Message('Votre compte a été activé.<br/>Vous pouvez vous connecter:','valid');
;
if ($_SERVER['HTTP_REFERER'] == $Url.'/bet') $Retour = Message('Vous devez être connecté pour parier','error');

$action = isset($_POST['action']) ? htmlspecialchars($_POST['action']) : null;
?>
<div class="forms">
<? 
	include 'templates/'.$template.'/login.php'; 
	include 'templates/'.$template.'/signup.php'; 
?>
</div>