<?
if (!$_SESSION['login']) {
    Redirection($Url);
	die;
}
if ($data) include 'templates/penalty/'.$data.'.php';
else include 'templates/penalty/index.php';
?>