<?
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
?>