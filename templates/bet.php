<?
$date = date('Y-n-d', time());

$id_game = isset($_POST['id_game']) ? intval($_POST['id_game']) : null;
$id_domicile = isset($_POST['id_domicile']) ? intval($_POST['id_domicile']) : null;
$id_visiteur = isset($_POST['id_visiteur']) ? intval($_POST['id_visiteur']) : null;
$sd = isset($_POST['sd']) ? intval($_POST['sd']) : null;
$sv = isset($_POST['sv']) ? intval($_POST['sv']) : null;

if ($User['credits']==0) {
    $_SESSION['message'] = Message('Vous n\'avez plus assez de crédit.<br /><a href="'.$Url.'/credits">Rechargez ici</a>','error');
    Redirection($Url);
    die;
}

$Games = $db->prepare('SELECT * FROM easybet_games WHERE id = ? AND id_domicile = ? AND id_visiteur = ?');
$Games->execute([$id_game, $id_domicile, $id_visiteur]);
$nbGames = $Games->rowCount();
$Game = $Games->fetch();

if ($nbGames!=1) {
    Redirection($Url);
    die;
}

$Check = $db->prepare('SELECT * FROM easybet_bets WHERE id_user=? AND date=?');
$Check->execute([$User['id'], $date]);
$nbCheck = $Check->rowCount();

if ($nbCheck>0) {
    $_SESSION['message'] = Message('Vous avez déjà joué aujourd\'hui.<br />Revenez demain !','info');
    Redirection($Url);
    die;
}

if ($sd > $sv) $bet = '1';
else if ($sd < $sv) $bet = '2';
else if ($sd == $sv) $bet = 'N';

$sql = 'INSERT INTO easybet_bets (id, `date`, id_game, id_user, score_d, score_v, bet) VALUES ("", "'.$date.'", '.$Game['id'].', '.$User['id'].', '.$sd.', '.$sv.', "'.$bet.'")';

$insert = $db->prepare($sql);
$insert->execute(); 

$update = $db->prepare('UPDATE easybet_users SET credits = credits-1 WHERE id=?');
$update->execute([$User['id']]);

$_SESSION['message'] = Message('Votre pari est enregistré. Merci','valid');
$_SESSION['bet']=1;

Redirection($Url);
?>