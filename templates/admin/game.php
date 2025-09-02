<?
$submit = isset($_POST['submit']) ? htmlspecialchars($_POST['submit']) : null;
$score_d = isset($_POST['score_d']) ? intval($_POST['score_d']) : null;
$score_e = isset($_POST['score_e']) ? intval($_POST['score_e']) : null;

if ($submit == 'OK') {
    if ($score_d > $score_e) $result = 1;
    else if ($score_d < $score_e) $result = 2;
    else if ($score_d == $score_e) $result = 'N';
    
    $game = $db->prepare('UPDATE easybet_games SET score_d = ?, score_v = ?, end = 1 WHERE id = ?');
    $game->execute([$score_d, $score_e, $niv3]);
    
    if ($result!= '') {
        $update = $db->prepare('UPDATE easybet_bets SET result = ? WHERE id_game = ?');
        if ($update->execute([$result, $niv3])) {
            $Bets = $db->prepare('SELECT * FROM easybet_bets WHERE id_game = ?');
            $Bets->execute([$niv3]);
            $nbBets = $Bets->rowCount();
            while ($Bet = $Bets->fetch()) {
                if ($Bet['score_d']==$score_d && $Bet['score_v']==$score_e) $points = 3;
                else if ($Bet['bet']==$result) $points = 1;
                else $points=0;

                $pts = $db->prepare('UPDATE easybet_users SET points = points + :points WHERE id=:id_user');
                $pts->execute(['points'=>$points, 'id_user'=>$Bet['id_user']]);
            }
            Redirection ($Url.'/'.$page);
        }
    }
}

$Jeux = $db->prepare('SELECT * FROM easybet_games WHERE id = ?');
$Jeux->execute([$niv3]);
$Jeu = $Jeux->fetch();

$id = $Jeu['id_domicile'];
$Equipes = $db->prepare('SELECT * FROM easybet_teams WHERE id = ?');
$Equipes->execute([$id]);
$One = $Equipes->fetch();

$id2 = $Jeu['id_visiteur'];
$Equipes2 = $db->prepare('SELECT * FROM easybet_teams WHERE id = ?');
$Equipes2->execute([$id2]);
$Two = $Equipes2->fetch();

?>

<div>
    <form method="post" class="score">
        <label for="score_d"><?=$One['team'];?></label>
        <input type="number" name="score_d" id="score_d" value="<?=$Jeu['score_d'];?>" />
        <label for="score_e"><?=$Two['team'];?></label>
        <input type="number" name="score_e" id="score_e" value="<?=$Jeu['score_v'];?>" />
        <input type="submit" name="submit" value="OK" />
    </form>
</div>

<style>
    input, label { text-align: center; }
</style>