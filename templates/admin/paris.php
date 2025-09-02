<?
$d = date('d',time());
$m = date('n',time());
$y = date('Y',time());

$date = date('Y-n-d', time());

$date_start = $y.'-'.$m.'-'.$d.' 00:00:00';
$date_end = $y.'-'.$m.'-'.$d.' 23:59:00';

$Paris = $db->prepare('SELECT * FROM easybet_bets WHERE date BETWEEN ? AND ?');
$Paris->execute([$date_start, $date_end]);
while ($Pari = $Paris->fetch()):
    $Players = $db->prepare('SELECT * FROM easybet_users WHERE id=?');
    $Players->execute([$Pari['id_user']]);
    $Player = $Players->fetch();

    $Games = $db->prepare('SELECT * FROM easybet_games WHERE id=?');
    $Games->execute([$Pari['id_game']]);
    $Game = $Games->fetch();
    
    $dom = $db->prepare('SELECT * FROM easybet_teams WHERE id=?');
    $dom->execute([$Game['id_domicile']]);
    $d = $dom->fetch();

    $vis = $db->prepare('SELECT * FROM easybet_teams WHERE id=?');
    $vis->execute([$Game['id_visiteur']]);
    $v = $vis->fetch();

    ?>
        <div class="bet">
            <div class="player"><?=$Player['pseudo'];?></div>
            <div class="game"><?=$d['team'].'-'.$v['team'];?></div>
            <div class="score"><?=$Pari['score_d'].'-'.$Pari['score_v'];?></div>
        </div>
    <?
endwhile;
?>

<style>
    div.admin {
        display: block;
        overflow: auto;
    }
    div.bet {
        width: 100%;
        max-width: 500px;
        margin: 5px auto;
        background: #fff;
        text-align: center;
    }
    div.bet div.player {
        width: 100%;
        background: #333;
        color: #fff;
        height: 30px;
        line-height: 30px;
    }
    div.bet div.game {
        width: 100%;
        color: #333;
        height: auto;
        line-height: auto;
        font-size: 1.5em;
        font-weight: bold;
    }
    div.bet div.score {
        color: rgb(0,104,55);
        font-weight: bold;
        height: 30px;
        line-height: 30px;
        font-size: 1.5em;
    }
</style>