<?
if ($_SESSION['login']!=1):
?>
<div class="login">
    <h2><strong>VOUS DEVEZ ÊTRE CONNECTÉ POUR JOUER</strong></h2>
    <a href="<?=$Url.'/login';?>">Me connecter / Créer un compte</a>
</div>
<?
endif;
?>
