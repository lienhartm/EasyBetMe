<div class="home">
<?
$nogame = 0;
$now = time();

$d = date('d',time());
$m = date('n',time());
$y = date('Y',time());

$date = date('Y-n-d', time());

$date_start = $y.'-'.$m.'-'.$d.' 00:00:00';
$date_end = $y.'-'.$m.'-'.$d.' 23:59:00';

$time = null;

$sql = 'SELECT * FROM easybet_games WHERE date BETWEEN ? AND ? ORDER BY date';
$Games = $db->prepare($sql);
$Games->execute([$date_start, $date_end]);
$nbGames = $Games->rowCount();

$sleep = 0;
if ($nbGames==0) {
    if ($sleep==1) {
        echo '<div class="nogame">easyBet est en maintenance et revient bientôt avec plus de fonctionnalités et plus de cadeaux.<br />En attendant suivez-bous sur Facebook...</div>';
    }
    else echo '<div class="nogame">Pas de match aujourd\'hui</div>';
} 

$Check = $db->prepare('SELECT * FROM easybet_bets WHERE id_user=? AND date=?');
$Check->execute([$User['id'], $date]);
$nbCheck = $Check->rowCount();
?>
<div class="games">
        <div class="head">
            <h2><strong>MATCHS DU JOUR</strong></h2>
        </div>
        <?
        if ($_SESSION['message']) {
            echo $_SESSION['message'];
            $_SESSION['message']=null;
        }

        while ($Game = $Games->fetch()):
            $date = strtotime($Game['date']);

            $gurl = $Url.'/play/'.$Game['id'];

            $dom = $db->prepare('SELECT * FROM easybet_teams WHERE id=?');
            $dom->execute([$Game['id_domicile']]);
            $d = $dom->fetch();

            $vis = $db->prepare('SELECT * FROM easybet_teams WHERE id=?');
            $vis->execute([$Game['id_visiteur']]);
            $v = $vis->fetch();

            $time = preg_replace('#([0-9]{4})-([0-9]{2})-([0-9]{2}) ([0-9]{2}):([0-9]{2}):([0-9]{2})#','\4:\5',$Game['date']);
            
            ?>
                <div class="game">
                    <p class="date"><span class="icon">&#xe94e;</span><?=$time;?></p>
                    
                    <p class="competition">
                        <?
                            switch ($Game['competition']) {
                                case 'Ligue 1':
                                    echo '<img src="'.$Url.'/images/competitions/ligue-1.png" />';
                                    echo '<strong>'.$Game['competition'].'</strong>';
                                    break;
                                case 'Ligue 2':
                                    echo '<img src="'.$Url.'/images/competitions/ligue-2.png" />';
                                    echo '<strong>'.$Game['competition'].'</strong>';
                                    break;
                                case 'La Liga':
                                    echo '<img src="'.$Url.'/images/competitions/la-liga.png" />';
                                    echo '<strong>'.$Game['competition'].'</strong>';
                                    break;
                                case 'Premier League':
                                    echo '<img src="'.$Url.'/images/competitions/premier-league.png" />';
                                    echo '<strong>'.$Game['competition'].'</strong>';
                                    break;
                                case 'Serie A':
                                    echo '<img src="'.$Url.'/images/competitions/seria-a.png" />';
                                    echo '<strong>'.$Game['competition'].'</strong>';
                                    break;
                                case 'Ligue des Champions':
                                    echo '<img src="'.$Url.'/images/competitions/ligues-des-champions.png" />';
                                    echo '<strong>'.$Game['competition'].'</strong>';
                                    break;
                                case 'Europa League':
                                    echo '<img src="'.$Url.'/images/competitions/europa-league.png" />';
                                    echo '<strong>'.$Game['competition'].'</strong>';
                                    break;
                                case 'Euro 2024':
                                    echo '<img src="'.$Url.'/images/euro2024.jpeg" />';
                                    echo '<strong>'.$Game['competition'].'</strong>';
                                    break;
                                default:
                                    echo '<strong>'.$Game['competition'].'</strong>';
                                    break;
                            }
                        ?>
                    </p>
                    
                    <div class="teams">
                        <div class="inline team">
                            <div class="logo">
                                <img src="<?=$Url.'/images/teams/'.$d['logo'];?>" alt="<?=$d['team'];?>" />
                            </div>
                            <p><strong><?=$d['team'];?></strong></p>
                        </div>

                        <div class="inline form">
                            <? if ($_SESSION['login']==1 && $nbCheck==0 && $date > time()): ?>
                                <form class="bet" method="POST" action="<?=$Url;?>/bet">
                                    <input type="hidden" name="id_game" value="<?=$Game['id'];?>" />
                                    <input type="hidden" name="id_domicile" value="<?=$Game['id_domicile'];?>" />
                                    <input type="hidden" name="id_visiteur" value="<?=$Game['id_visiteur'];?>" />
                                    <div class="team">
                                        <input type="number" name="sd" min="0" value="0" />
                                    </div>    
                                    <div class="team">
                                        <input type="number" name="sv" min="0" value="0" />
                                    </div>  
                                    <div class="submit">  
                                        <input type="submit" value="Valider" />
                                    </div>
                                </form>
                            <? else: ?>
                                <p class="empty">0</p>
                            <? endif; ?>
                        </div>

                        <div class="inline team">
                            <div class="logo">
                                <img src="<?=$Url.'/images/teams/'.$v['logo'];?>" alt="<?=$v['team'];?>" />
                            </div>
                            <p><strong><?=$v['team'];?></strong></p>
                        </div>
                    </div>
                    <? if ($_SESSION['login']!=1): ?>
                        <div class="closed">
                            <div class="picto">
                                <span class="icon">&#xea0c;</span>
                            </div>
                            <div class="msg">
                                <p>Vous devez être connecté pour jouer.<br /><a href="<?=$Url;?>/login">Se connecter / Créer un compte</a>.</p>
                            </div>
                        </div>
                    <? elseif ($nbCheck>0): ?>
                        <div class="closed">
                            <div class="picto">
                                <span class="icon">&#xea0c;</span>
                            </div>
                            <div class="msg">
                                <p>Vous avez déjà parié aujourd'hui.<br />Revenez demain.</p>
                            </div>
                        </div>
                    <? elseif ($date < time()): ?>
                        <div class="closed">
                            <div class="picto">
                                <span class="icon">&#xea0c;</span>
                            </div>
                            <div class="msg">
                                <p>Le match a commencé.<br />Vous ne pouvez plus faire de pronostic sur ce match</p>
                            </div>
                        </div>
                    <? endif; ?>
                </div>
            <? 
        endwhile;
    ?>
</div>
</div>
