<?
if (!$_SESSION['login']) {
    Redirection($Url);
	die;
}

if ($data) include 'templates/profile/'.$data.'.php';
else include 'templates/profile/index.php';
?>