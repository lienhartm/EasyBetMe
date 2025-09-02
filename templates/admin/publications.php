<?
header('Content-type:image/jpeg');

$sql = 'SELECT * FROM easybet_games WHERE id = ?';
$Games = $db->prepare($sql);
$Games->execute([$niv3]);
$Game = $Games->fetch();

$dom = $db->prepare('SELECT * FROM easybet_teams WHERE id=?');
$dom->execute([$Game['id_domicile']]);
$d = $dom->fetch();

$vis = $db->prepare('SELECT * FROM easybet_teams WHERE id=?');
$vis->execute([$Game['id_visiteur']]);
$v = $vis->fetch();

$date = strtotime($Game['date']);
$time = preg_replace('#([0-9]{4})-([0-9]{2})-([0-9]{2}) ([0-9]{2}):([0-9]{2}):([0-9]{2})#','\4:\5',$Game['date']);
?>

<div class="post">
    <img src="<?=$Url.'/images/logo-easybet.png';?>">

    <div class="show">
        <div class="game">
            <div class="team">
                <img src="<?=$Url.'/images/teams/'.$d['logo'];?>">
                <strong><?=$d['team'];?></strong>
            </div>
            <div class="time"><?=$time;?></div>
            <div class="team">
                <img src="<?=$Url.'/images/teams/'.$v['logo'];?>">
                <strong><?=$v['team'];?></strong>
            </div>
        </div>
    </div>
</div>

<style>
    header, footer {
        display: none;
    }
    body.football {
        background: transparent;
    } 

    main {
        width: 100%;
        height: 100%;
    }
    div.admin {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    div.post {
        background-image: url(../images/football.jpg);
        background-size: cover;
        background-position: -250px -1px;
        width: 800px;
        height: 500px;
        border: solid 1px #dbdbdb;
        text-align: center;
        position: relative;
    }
    div.post h2 {
        width: 100%;
        height: 50px;
        line-height: 50px;
        margin: 0;
        padding: 0;
    }
    div.post div.show {
        width: 100%;
        height: 100%;
        line-height: 50px;
        margin: 0;
        padding: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        position: absolute;
        top: 0;
        left: 0;
    }
    div.post div.show div.game {
        width: 500px;
        height: 250px;
        background: rgba(255, 255, 255, 0.8);
    }
    div.post div.show div.game div.team {
        width: 200px;
        height: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        float: left;
    }
    div.post div.show div.game div.team img {
        display: block;
        width: 100px;
        height: auto;
    }
    div.post div.show div.game div.team strong {
        display: block;
        width: 100%;
    }
    div.post div.show div.game div.time {
        width: 100px;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        float: left;
        font-weight: bolder;
        font-size: 2em;
    }
</style>