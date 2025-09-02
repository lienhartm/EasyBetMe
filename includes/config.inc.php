<?php
session_start();

$id_site = intval(file('includes/id_site.txt')[0]);

$db_server = 'db5001933572.hosting-data.io';
$db_name = 'dbs1582075';
$db_login = 'dbu1385152';
$db_password = 'IiBr8ICK0x!?xHd2PQ1CT4B8';

$mail_pwd = 'kA+W2x2dKP,9XBv';

try {
	$db = new PDO('mysql:host='.$db_server.';dbname='.$db_name.';charset=utf8', $db_login, $db_password);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (PDOException $e) {
	Message('Falta connexão','error');
	exit;
}

$_SESSION['login']=0;
if ($_SESSION['email'] && $_SESSION['auth']) {
    $Users = $db->prepare('SELECT * FROM easybet_users WHERE email = :email AND auth = :auth AND off = 0');
    $Users->execute(array('email'=>$_SESSION['email'], 'auth'=>$_SESSION['auth']));
    $User = $Users->fetch();
	if ($Users->rowCount() == 1) $_SESSION['login']=1;
	else $_SESSION['login']= array();
}

$Sites = $db->query('SELECT * FROM sites WHERE id = "'.$id_site.'" LIMIT 1');
$Site = $Sites->fetch();

$Nom = $Site['nom'];
$Url = $Site['url'];

$Tools = '../../tools/';

if (strtoupper(substr(PHP_OS,0,3)=='WIN')) { $eol="\r\n"; } 
elseif (strtoupper(substr(PHP_OS,0,3)=='MAC')) { $eol="\r"; } 
else { $eol="\n"; }

$Formules = array(
    1 => 1,
    5 => 3,
    10 => 5
);
?>