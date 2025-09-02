<?
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
                $message.='<td style="width: 250px; text-align: center;">';
                    $message.= '<strong>'.$d['team'].'</strong>';
                $message.='</td>';

                $message.='<td style="width: 100px; text-align: center;">';
                    $message.= $Game['score_d'].'-'.$Game['score_v'];
                $message.='</td>';

                $message.='<td style="width: 250px; text-align: center;">';
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
?>