<div class="content">
    <?
        include 'templates/'.$page.'/commun.php';
    ?>

    <div class="main classement">
        <h2><strong>Pronostics</strong></h2>

        <div class="datas">
            <div class="head">
                <div class="date">Date</div>
                <div class="game">Match</div>
                <div class="point">Points</div>
            </div>
            <?
                $j = 1;
                $Parties = $db->prepare('SELECT * FROM easybet_bets WHERE id_user=? ORDER BY date DESC');
                $Parties->execute([$User['id']]);
                while ($Partie = $Parties->fetch()):
                    $Games = $db->prepare('SELECT * FROM easybet_games WHERE id=?');
                    $Games->execute([$Partie['id_game']]);
                    $Game = $Games->fetch();

                    $points = 0;
                    $class = 'lost';
                    if ($Game['score_d']==$Partie['score_d'] && $Game['score_v']==$Partie['score_v']): 
                        $points = 3; 
                        $class = 'full'; 
                    elseif ($Partie['result']==$Partie['bet']): 
                        $points = 1; 
                        $class = 'straight'; 
                    endif;
                    ?>
                        <div class="body">
                            <div class="date">
                                <?
                                    $date = preg_replace('#([0-9]{4})-([0-9]{2})-([0-9]{2}) ([0-9]{2}):([0-9]{2}):([0-9]{2})#','\3-\2-\1',$Partie['date']);
                                    echo $date;
                                ?>
                            </div>
                            <div class="game">
                                <div class="team">
                                    <?
                                        $dom = $db->prepare('SELECT * FROM easybet_teams WHERE id=?');
                                        $dom->execute([$Game['id_domicile']]);
                                        $d = $dom->fetch();
                                    ?>
                                    <div class="logo">
                                        <img src="<?=$Url.'/images/teams/'.$d['logo'];?>" alt="<?=$d['team'];?>" />
                                    </div>
                                    <p><?=$d['team'];?></p>
                                </div>
                                <div class="scores">
                                    <p class="intro">Résultat final:</p>
                                    <? if ($Game['end']==1): ?>
                                    <p class="score real"><?=$Game['score_d'].'-'.$Game['score_v'];?></p>
                                    <? else: ?>
                                    <p class="score real"><span>En cours...</span></p>
                                    <? endif; ?>
                                    <p class="intro">Votre pronostic:</p>
                                    <p class="score <?=$class;?>"><?=$Partie['score_d'].'-'.$Partie['score_v'];?></p>
                                </div>
                                <div class="team">
                                    <?
                                        $ext = $db->prepare('SELECT * FROM easybet_teams WHERE id=?');
                                        $ext->execute([$Game['id_visiteur']]);
                                        $e = $ext->fetch();
                                    ?>
                                    <p><?=$e['team'];?></p>
                                    <div class="logo">
                                        <img src="<?=$Url.'/images/teams/'.$e['logo'];?>" alt="<?=$e['team'];?>" />
                                    </div>
                                </div>
                            </div>
                            <div class="points">
                                <?
                                    if ($Game['end']==1):
                                        if ($points>1) echo $points.' pts';
                                        else echo $points.' pt';
                                    else:
                                        echo '&nbsp;';
                                    endif;
                                ?>
                            </div>
                        </div>
                    <?
                    $j++;
                endwhile;
            ?>
        </div>
    </div>
</div>
