<div class="game">
    <p class="title"><strong>Demain</strong></p>
    <ul>
    <?
        $demain = date('Y-n-d',(time() + (24 * 60 * 60)));
        $Jeux = $db->query('SELECT * FROM easybet_games WHERE date >= "'.$demain.'" ORDER BY date ASC LIMIT 1');
        while ($Jeu = $Jeux->fetch()) {
            echo '<li>';
            // echo '<em>'.rDate($Jeu['date']).'</em>';
            echo '<em>'.preg_replace('#([0-9]{4})-([0-9]{2})-([0-9]{2}) ([0-9]{2}):([0-9]{2}):([0-9]{2})#','\3.\2 - \4:\5',$Jeu['date']).'</em>';
            echo '<span class="team">';
                    $i1 = $Jeu['id_domicile'];
                    $ts = $db->prepare('SELECT * FROM easybet_teams WHERE id = ?');
                    $ts->execute([$i1]);
                    $t1 = $ts->fetch();
                    echo '<img src="'.$Url.'/images/teams/'.$t1['logo'].'" alt="'.$t1['team'].'" />';
                    echo '<label>'.$t1['team'].'</label>';
                echo '</span>';
                echo '<span class="team" style="text-align: right;">';
                    $i2 = $Jeu['id_visiteur'];
                    $ts = $db->prepare('SELECT * FROM easybet_teams WHERE id = ?');
                    $ts->execute([$i2]);
                    $t2 = $ts->fetch();
                    echo '<label>'.$t2['team'].'</label>';
                    echo '<img src="'.$Url.'/images/teams/'.$t2['logo'].'" alt="'.$t2['team'].'" />';
                echo '</span>';
            echo '</li>';
        }
    ?>
    </ul>

    <p class="title"><strong>Hier</strong></p>
    <ul>
    <?
        $demain = date('Y-n-d',(time() + (24 * 60 * 60)));
        $Jeux = $db->query('SELECT * FROM easybet_games WHERE date <= "'.$demain.'" ORDER BY date ASC LIMIT 1');
        while ($Jeu = $Jeux->fetch()) {
            echo '<li onclick="document.location.href=\''.$Url.'/'.$page.'/game/'.$Jeu['id'].'\';">';
            // echo '<em>'.rDate($Jeu['date']).'</em>';
            echo '<em>'.preg_replace('#([0-9]{4})-([0-9]{2})-([0-9]{2}) ([0-9]{2}):([0-9]{2}):([0-9]{2})#','\3.\2 - \4:\5',$Jeu['date']).'</em>';
            echo '<span class="team">';
                    $i1 = $Jeu['id_domicile'];
                    $ts = $db->prepare('SELECT * FROM easybet_teams WHERE id = ?');
                    $ts->execute([$i1]);
                    $t1 = $ts->fetch();
                    echo '<img src="'.$Url.'/images/teams/'.$t1['logo'].'" alt="'.$t1['team'].'" />';
                    echo '<label>'.$t1['team'].'</label>';
                echo '</span>';
                echo '<span class="team" style="text-align: right;">';
                    $i2 = $Jeu['id_visiteur'];
                    $ts = $db->prepare('SELECT * FROM easybet_teams WHERE id = ?');
                    $ts->execute([$i2]);
                    $t2 = $ts->fetch();
                    echo '<label>'.$t2['team'].'</label>';
                    echo '<img src="'.$Url.'/images/teams/'.$t2['logo'].'" alt="'.$t2['team'].'" />';
                echo '</span>';
            echo '</li>';
        }
    ?>
    </ul>
</div>
