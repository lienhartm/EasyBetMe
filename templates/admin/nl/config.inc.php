<?
if (strtoupper(substr(PHP_OS,0,3)=='WIN')) { $eol="\r\n"; } 
elseif (strtoupper(substr(PHP_OS,0,3)=='MAC')) { $eol="\r"; } 
else { $eol="\n"; }

$usr = array();

$date = date('Y-n-d',time());
$hier = date('Y-n-d',(time() - (24*3600)));

$Players = $db->prepare('SELECT * FROM easybet_users WHERE last_nl != ? AND off=0');
$Players->execute([$date]);
?>