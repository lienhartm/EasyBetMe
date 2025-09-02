<?
$d = date('d',time());
$m = date('n',time());
$y = date('Y',time());

$date = date('Y-n-d', time());

$date_start = $y.'-'.$m.'-'.$d.' 00:00:00';
$date_end = $y.'-'.$m.'-'.$d.' 23:59:00';

$Paris = $db->prepare('SELECT * FROM easybet_bets WHERE date BETWEEN ? AND ?');
$Paris->execute([$date_start, $date_end]);

function fetchMatchData($id_game) {
    $url = 'http://api.football-data.org/v4/matches/' . $id_game;
    $token = '03deaacc0cbb4915817e2843b5b0f811';

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'X-Auth-Token: ' . $token
    ]);
    $response = curl_exec($ch);
    curl_close($ch);

    return json_decode($response, true);
}

while ($Pari = $Paris->fetch()):
    $Players = $db->prepare('SELECT * FROM easybet_users WHERE id=?');
    $Players->execute([$Pari['id_user']]);
    $Player = $Players->fetch();

    $matches = fetchMatchData($Pari['id_game']);

    /*
    $Games = $db->prepare('SELECT * FROM easybet_games WHERE id=?');
    $Games->execute([$Pari['id_game']]);
    $Game = $Games->fetch();
    
    $dom = $db->prepare('SELECT * FROM easybet_teams WHERE id=?');
    $dom->execute([$Game['id_domicile']]);
    $d = $dom->fetch();

    $vis = $db->prepare('SELECT * FROM easybet_teams WHERE id=?');
    $vis->execute([$Game['id_visiteur']]);
    $v = $vis->fetch();
    */
    ?>
        <div class="bet">
            <div class="player"><?=$Player['pseudo'];?></div>
            <div class="game"><?=$matches['homeTeam']['name']?> - <?= $matches['awayTeam']['name']?></div>
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