<?
if ($_SESSION['login']!=1 || ($User['id']!=1 && $User['id']!=2 && $User['id']!=31)) {
	Redirection($Url);
	die;
}

?>
<div class="admin">
<?
if ($data) include 'templates/'.$page.'/'.$data.'.php';
else include 'templates/'.$page.'/index.php';
?>
</div>

