<?
$date_start = $date.' 00:00:00';
$date_end = $date.' 23:59:00';

$Games = $db->prepare('SELECT * FROM easybet_games WHERE date BETWEEN ? AND ?');
$Games->execute([$date_start, $date_end]);
$nbGames = $Games->rowCount();

if ($nbGames>0) {

    $message.= '<h3 style="text-align: center; color: rgb(0,104,55);"><strong>A l\'affiche aujourd\'hui sur easyBet&nbsp;:</strong></h3>';
    /*
    $message.= '<div style="width: 100%; margin: 10px auto;">';
    while ($Game = $Games->fetch()):
        $Dom = $db->prepare('SELECT * FROM easybet_teams WHERE id=?');
        $Vis = $db->prepare('SELECT * FROM easybet_teams WHERE id=?');
        $Dom->execute([$Game['id_domicile']]);
        $Vis->execute([$Game['id_visiteur']]);
        $d = $Dom->fetch();
        $v = $Vis->fetch();

        
            $message.= '<div style="width: 100%; text-align: center;">';
                $message.= '<div style="display: flex; width: 100%; margin: 0 auto;">';
                    $message.= '<div style="width: 40%; text-align: center;">';    
                        $message.= '<p><a href="'.$Url.'"><img src="'.$Url.'/images/teams/'.$d['logo'].'" alt="'.$d['team'].'" style="width: 50px; height: 50px" /></a></p>';
                        $message.= '<p><a href="'.$Url.'" style="color: #000;"><strong>'.$d['team'].'</strong></a></p>';
                    $message.= '</div>';

                    $message.= '<div style="width: 20%; line-height: 80px; text-align: center;"><em>'.preg_replace('#([0-9]{4})-([0-9]{2})-([0-9]{2}) ([0-9]{2}):([0-9]{2}):([0-9]{2})#','\4h\5',$Game['date']).'</em></div>';
                    
                    $message.= '<div style="width: 40%; text-align: center;">';
                        $message.= '<p><a href="'.$Url.'"><img src="'.$Url.'/images/teams/'.$v['logo'].'" alt="'.$v['team'].'" style="width: 50px; height: 50px" /></a></p>';
                        $message.= '<p><a href="'.$Url.'" style="color: #000;"><strong>'.$v['team'].'</strong></a></p>';
                $message.= '</div>';
            $message.= '</div>';
        $message.= '</div>';

    endwhile;
    */
}


?>