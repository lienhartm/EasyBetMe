<?
if ($_SESSION['login']!=1 || ($User['id']!=1 && $User['id']!=2)) {
	Redirection($Url);
	die;
}
Title ('Administration - '.$Site['nom']);
?>
<div class="admin">
<?
include ($data!='') ? 'templates/'.$page.'/'.$data.'.php' : 'templates/'.$page.'/index.php';
?>
</div>

