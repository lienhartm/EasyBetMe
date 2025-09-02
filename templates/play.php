<?
$now = time();

$d = date('d',time());
$m = date('n',time());
$y = date('Y',time());

$date_start = $y.'-'.$m.'-'.$d.' 00:00:00';
$date_end = $y.'-'.$m.'-'.$d.' 23:59:00';

$Games = $db->prepare('SELECT * FROM easybet_games WHERE id = ? AND date BETWEEN ? AND ?');
$Games->execute([$data, $date_start, $date_end]);

$nbGames = $Games->rowCount();
if ($nbGames!=1) {
    Redirection($Url);
    die;
}

$Game = $Games->fetch();

$date = strtotime($Game['date']);

if (time() > $date) {
    Redirection($Url);
    die;  
}

$dom = $db->prepare('SELECT * FROM easybet_teams WHERE id = ?');
$ext = $db->prepare('SELECT * FROM easybet_teams WHERE id = ?');
$dom->execute([$Game['id_domicile']]);
$ext->execute([$Game['id_visiteur']]);
$d = $dom->fetch();
$e = $ext->fetch();
?>

<div class="game">
    <p class="date"><em><?=preg_replace('#([0-9]{4})-([0-9]{2})-([0-9]{2}) ([0-9]{2}):([0-9]{2}):([0-9]{2})#','\3-\2-\1 - \4h\5',$Game['date']);?></em></p>
    <div class="teams">
        <div class="team">
            <div class="logo">
                <img src="<?=$Url.'/images/teams/'.$d['logo'];?>" alt="<?=$d['team'];?>" />
            </div>
            <p class="team"><strong><?=$d['team'];?></strong></p>
        </div>
        <div class="team">
            <div class="logo">
                <img src="<?=$Url.'/images/teams/'.$e['logo'];?>" alt="<?=$e['team'];?>" />
            </div>
            <p class="team"><strong><?=$e['team'];?></strong></p>
        </div>
    </div>

    <? if ($User['id']>0): ?>
        <p class="instructions">Saissez le score de votre pronostic:</p>
        <form method="POST" action="<?=$Url.'/bet';?>">
            <input type="hidden" name="id_game" value="<?=$Game['id'];?>" />
            <input type="hidden" name="id_domicile" value="<?=$Game['id_domicile'];?>" />
            <input type="hidden" name="id_visiteur" value="<?=$Game['id_visiteur'];?>" />
            <div class="teams">
                <div class="team">
                    <input type="number" name="sd" min="0" value="0" />
                </div>
                <div class="team">
                    <input type="number" name="sv" min="0" value="0" />
                </div>
            </div>
            <input type="submit" value="Valider" />
        </form>
    <? else: ?>
        <p class="instructions">Vous devez être connecté pour jouer...</p>
    <? endif; ?>
</div>