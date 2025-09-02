<link rel="stylesheet" href="<?=$Url.'/templates/admin/nl/styles.css';?>" />
<div class="nl">
<? 

if (strtoupper(substr(PHP_OS,0,3)=='WIN')) { $eol="\r\n"; } 
elseif (strtoupper(substr(PHP_OS,0,3)=='MAC')) { $eol="\r"; } 
else { $eol="\n"; }

$expediteur = 'contact@easybet.me';
$sujet = 'Les matchs du jour sur '.$Site['nom'];	

$headers = 'From: '.$expediteur.$eol;
$headers.= 'Reply-To:'.$expediteur.$eol;
$headers.= 'MIME-Version: 1.0'.$eol;
$headers.= 'Content-Type: text/html; charset=utf-8'.$eol;

$usr = array();
$nbnl=0;

$date = date('Y-n-d',time());
$hier = date('Y-n-d',(time() - (24*3600)));

$Players = $db->prepare('SELECT * FROM easybet_users WHERE last_nl != ? AND off=0');
$Players->execute([$date]);

while ($Player = $Players->fetch()) {
    // Header 
    $message = '<table style="width: 800px;">';
    $message.= '<tr>';
        $message.='<td style="width: 220px;><a href="'.$Url.'"><img src="https://www.easybet.me/images/logo-easybet.png" /></a></td>';
        $message.= '<td style="width: 580px; text-align: right;" colspan="2">';
            $Joueurs = $db->prepare('SELECT * FROM easybet_users WHERE off = 0 ORDER BY points DESC');
            $Joueurs->execute();
            $nbJoueurs = $Joueurs->rowCount();

            $p = 1;
            while ($Joueur = $Joueurs->fetch()) {
                if ($Joueur['id']==$Player['id']) {
                    $pos = $p;
                }
                $p++;
            }
            $message.= '<span>Vous êtes: <strong>';
            $message.= ($pos==1) ? $pos.'<sup>er</sup>' : $pos.'<sup>e</sup>';
            $message.= '&nbsp;/&nbsp;'.$nbJoueurs.'</strong> ';

            if ($Player['points']>1) $message.= '<span>(<strong>'.$Player['points'].'</strong> points)</span>&nbsp;';
            else $message.= '<span>(<strong>'.$Player['points'].'</strong> point)</span>';
            $message.= '&nbsp;-&nbsp;';
            
            if ($Player['credits']>1) $message.= '<strong>'.$Player['credits'].'&nbsp;crédits</strong>';
            else $message.= '<strong>'.$Player['credits'].'&nbsp;crédit</strong>';
        $message.= '</td>';
    $message.= '</tr>';

    // Hier 
    $Bets = $db->prepare('SELECT * FROM easybet_bets WHERE date=? AND id_user=?');
    $Bets->execute([$hier, $Player['id']]);
    $nbBets = $Bets->rowCount();

    if ($nbBets>0):

    $Bet = $Bets->fetch();

    $Games = $db->prepare('SELECT * FROM easybet_games WHERE id=?');
    $Games->execute([$Bet['id_game']]);
    $Game = $Games->fetch();

    $Dom = $db->prepare('SELECT * FROM easybet_teams WHERE id=?');
    $Dom->execute([$Game['id_domicile']]);
    $d = $Dom->fetch();

    $Vis = $db->prepare('SELECT * FROM easybet_teams WHERE id=?');
    $Vis->execute([$Game['id_visiteur']]);
    $v = $Vis->fetch();

    $message.= '<tr>';
        $message.='<td colspan="3">';
            $message.= '<p>Bonjour  '.$Player['pseudo'].',</p>';
            $message.= '<p>Voici le résultat de votre pronostic d\'hier:</p>';
        $message.='</td>';
    $message.= '</tr>';

    $message.= '<tr>';
        $message.='<td colspan="3">';
            $message.='<table style="width: 100%;">';
                $message.='<tr>';
                    $message.='<td style="width: 100px; text-align: center;">';
                        $message.= '<img src="'.$Url.'/images/teams/'.$d['logo'].'" style="width: auto; height: 50px;" />';
                    $message.='</td>';
                    $message.='<td style="width: 250px; text-align: left;">';
                        $message.= '<strong>'.$d['team'].'</strong>';
                    $message.='</td>';

                    $message.='<td style="width: 100px; text-align: center;">';
                        $message.= $Game['score_d'].'-'.$Game['score_v'];
                    $message.='</td>';

                    $message.='<td style="width: 250px; text-align: right;">';
                        $message.= '<strong>'.$v['team'].'</strong>';
                    $message.='</td>';
                    $message.='<td style="width: 100px; text-align: center;">';
                        $message.= '<img src="'.$Url.'/images/teams/'.$v['logo'].'" style="width: auto; height: 50px;" />';
                    $message.='</td>';
                $message.='</tr>';
            $message.='</table>';
    $message.= '</tr>';

    $message.= '<tr>';
    $message.= '<td colspan="3">';
        $message.= '<p>Votre pronostic: <strong>'.$Bet['score_d'].'-'.$Bet['score_v'].'</strong></p>';

        if ($Bet['score_d']==$Game['score_d'] && $Bet['score_v']==$Game['score_v']):
            $message.= '<p>Bravo, vous avez gagné 3 points !</p>';
        elseif ($Bet['bet']==$Bet['result']):
            $message.= '<p>Bravo, vous avez gagné 1 point !</p>';
        else:
            $message.= '<p>Hélas, vous avez perdu !</p>';
        endif;

        $message.= '<p>Rejouez dès aujourd\'hui, avec les matchs du jour:</p>';
    $message.= '</td>';
    $message.= '</tr>';

    else:

    $message.= '<tr>';
    $message.='<td colspan="3">';
        $message.= '<p>Bonjour  '.$Player['pseudo'].',</p>';
        $message.= '<p>Vous nous avez manqué hier... mais vous pouvez rejouer dès aujourd\'hui:</p>';
    $message.='</td>';
    $message.= '</tr>';

    endif;

    // Affiches 
    $date_start = $date.' 00:00:00';
    $date_end = $date.' 23:59:00';

    $Games = $db->prepare('SELECT * FROM easybet_games WHERE date BETWEEN ? AND ? ORDER BY date');
    $Games->execute([$date_start, $date_end]);
    $nbGames = $Games->rowCount();

    if ($nbGames>0):
        $message.= '<tr>';
            $message.= '<td colspan="3">';
                while ($Game = $Games->fetch()):
                    $Dom = $db->prepare('SELECT * FROM easybet_teams WHERE id=?');
                    $Vis = $db->prepare('SELECT * FROM easybet_teams WHERE id=?');
                    $Dom->execute([$Game['id_domicile']]);
                    $Vis->execute([$Game['id_visiteur']]);
                    $d = $Dom->fetch();
                    $v = $Vis->fetch();
                                
                    $message.='<table style="width: 100%;">';
                    $message.='<tr>';
                        $message.='<td style="width: 100px; text-align: center;">';
                            $message.= '<img src="'.$Url.'/images/teams/'.$d['logo'].'" style="width: auto; height: 50px;" />';
                        $message.='</td>';
                        $message.='<td style="width: 250px; text-align: left;">';
                            $message.= '<strong>'.$d['team'].'</strong>';
                        $message.='</td>';
    
                        $message.='<td style="width: 100px; text-align: center;">';
                            $message.= preg_replace('#([0-9]{4})-([0-9]{2})-([0-9]{2}) ([0-9]{2}):([0-9]{2}):([0-9]{2})#','\4:\5',$Game['date']);
                        $message.='</td>';
    
                        $message.='<td style="width: 250px; text-align: right;">';
                            $message.= '<strong>'.$v['team'].'</strong>';
                        $message.='</td>';
                        $message.='<td style="width: 100px; text-align: center;">';
                            $message.= '<img src="'.$Url.'/images/teams/'.$v['logo'].'" style="width: auto; height: 50px;" />';
                        $message.='</td>';
                    $message.='</tr>';
                $message.='</table>';
                    endwhile;
            $message.= '</td>';
        $message.= '</tr>';
    endif;

    // Footer
        $message.= '<tr>';
            $message.= '<td colspan="3">';
                $message.= '<p style="text-align: center;">A tout de suite sur <a href="'.$Url.'">'.$Site['nom'].'</a> pour votre pari du jour</p>';
                $message.= '<p style="font-size: 0.9em; text-align: center;"><a href="'.$Url.'/unsuscribe/'.$User['auth'].$User['id'].'">Se désabonner</a></p>';
            $message.= '</td>';
        $message.= '</tr>';
    $message.= '</table>';

    
    // echo $message;
    if (mail($Player['email'], $sujet, $message, $headers)) {
        $update = $db->prepare('UPDATE easybet_users SET last_nl = "'.$date.'" WHERE id = '.$Player['id']);
        $update -> execute();
        $usr[]= $Player['email'];
    }
}

foreach ($usr as $u) echo $u.'<br />';
?>
</div>