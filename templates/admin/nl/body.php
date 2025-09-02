<?
$id_site = 27;

$db_server = 'db5001933572.hosting-data.io';
$db_name = 'dbs1582075';
$db_login = 'dbu1385152';
$db_password = 'IiBr8ICK0x!?xHd2PQ1CT4B8';

try {
	$db = new PDO('mysql:host='.$db_server.';dbname='.$db_name.';charset=utf8', $db_login, $db_password);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (PDOException $e) {
	Message('Falta connexão','error');
	exit;
}

$Sites = $db->query('SELECT * FROM sites WHERE id = 27');
$Site = $Sites->fetch();

$now = time();
$d = date('d',time());
$m = date('n',time());
$y = date('Y',time());

$date_start = $y.'-'.$m.'-'.$d.' 00:00:00';
$date_end = $y.'-'.$m.'-'.$d.' 23:59:00';

$sql = 'SELECT * FROM easybet_games WHERE date BETWEEN :date_start AND :date_end LIMIT 1';
$Games = $db->prepare($sql);
$Games->execute(array('date_start'=>$date_start, 'date_end'=>$date_end));
$Game = $Games->fetch();

$Domiciles = $db->prepare('SELECT * FROM easybet_teams WHERE id = :id_domicile');
$Domiciles->execute(array('id_domicile'=>$Game['id_domicile']));
$Domicile = $Domiciles->fetch();
$logod = $Domicile['logo'];

$Visiteurs = $db->prepare('SELECT * FROM easybet_teams WHERE id = :id_visiteur');
$Visiteurs->execute(array('id_visiteur'=>$Game['id_visiteur']));
$Visiteur = $Visiteurs->fetch();
$logov = $Visiteur['logo'];
?>


<div style="width: 700px; margin: 10px auto;">
	<h1 style="width: 100%; text-align: center;"><a href="<?=$Url;?>"><img src="<?=$Url;?>/images/logo-easybet.gif" /></a></h1>
	<p>Chère, Cher <?=$Player['pseudo'];?>,</p>
    <p>Voici l'affiche du jour sélectionnée pour vous sur <strong><?=$Site['nom'];?></strong></p>
	<div style="display: flex; width: 100%;">
		<div style="width: 50%; text-align: center;">
			<p><a href="<?=$Url;?>"><img src="<?=$Url.'/images/teams/'.$Domicile['logo'];?>" alt="<?=$Domicile['team'];?>" /></a></p>
			<p><a href="<?=$Url;?>" style="color: #000;"><strong><?=$Domicile['team'];?></strong></a></p>
		</div>
		<div style="width: 50%; text-align: center;">
			<p><a href="<?=$Url;?>"><img src="<?=$Url.'/images/teams/'.$Visiteur['logo'];?>" alt="<?=$Visiteur['team'];?>" /></a></p>
			<p><a href="<?=$Url;?>" style="color: #000;"><strong><?=$Visiteur['team'];?></strong></a></p>
		</div>
	</div>

    <p>Faites votre pronostic pour tenter de remporter la première place !</p>
</div>