<?
if (!$_SESSION['login']) {
    Redirection($Url);
	die;
}
if ($data) include 'templates/gift/'.$data.'.php';
else include 'templates/gift/index.php';
?>