<link rel="stylesheet" href="<?=$Url.'/templates/admin/nl/styles.css';?>" />
<div class="nl">
<? 
$id = isset($_POST['id']) ? intval($_POST['id']): null;
$position = isset($_POST['position']) ? intval($_POST['position']): null;
$credits = isset($_POST['credits']) ? intval($_POST['credits']): null;

if (strtoupper(substr(PHP_OS,0,3)=='WIN')) { $eol="\r\n"; } 
elseif (strtoupper(substr(PHP_OS,0,3)=='MAC')) { $eol="\r"; } 
else { $eol="\n"; }

$expediteur = 'contact@easybet.me';
$sujet = 'Classement mensuel sur '.$Site['nom'];	

$headers = 'From: '.$expediteur.$eol;
$headers.= 'Reply-To:'.$expediteur.$eol;
$headers.= 'MIME-Version: 1.0'.$eol;
$headers.= 'Content-Type: text/html; charset=utf-8'.$eol;

$usr = array();
$nbnl=0;

$date = date('Y-n-d',time());
$hier = date('Y-n-d',(time() - (24*3600)));

$Gamers = $db->prepare('SELECT * FROM easybet_users WHERE off=0 ORDER BY points DESC');
$Gamers->execute();
$nbGamers = $Gamers->rowCount();
?>
<form method="post">
    <select name="id">
    <?    
        while ($Gamer = $Gamers->fetch()):
            if ($id==$Gamer['id']):
            ?>
                <option value="<?=$Gamer['id'];?>" selected="selected"><?=$Gamer['pseudo'];?></option>
            <?
            else:
            ?>
                <option value="<?=$Gamer['id'];?>"><?=$Gamer['pseudo'];?></option>
            <?
            endif;
        endwhile;
    ?>
    </select>
    <input type="number" name="position" placeholder="Position" value="<?=$position;?>">
    <input type="number" name="credits" placeholder="Crédits" value="<?=$credits;?>">
    <input type="submit" value="OK">
</form>

<div class="msg">
<?
if ($id):
    $Players = $db->prepare('SELECT * FROM easybet_users WHERE id=?');
    $Players->execute([$id]);
    $Player = $Players->fetch();

    $message = '<table style="width: 800px; margin: 0 auto;">';
        $message.= '<tr>';
            $message.='<td style="width: 800px; text-align: center"><a href="'.$Url.'"><img src="https://www.easybet.me/images/logo-easybet.png" /></a></td>';
        $message.= '</tr>';
        $message.= '<tr>';
            $message.='<td style="width: 800px; text-align: left">';
                $message.='<p>Bonjour '.$Player['pseudo'].',</p>';
                $pos.= ($position==1) ? $position.'<sup>er</sup>' : $position.'<sup>e</sup>';
                $message.='<p>Félicitations, grâce à votre performance, vous avez terminé <strong>'.$pos.'/'.$nbGamers.'</strong> dans le classement <a href="'.$Url.'">easyBet.me</a> ce mois-ci !</p>';
                $message.='<h2 style="text-align: center; color: rgb(0,104,55);"><strong>'.$pos.'/'.$nbGamers.'</strong></h2>';
                $message.='<p>Nous avons le plaisir de vous offrir <strong style="color: rgb(0,104,55);">'.$credits.' crédits</strong> supplémentaires pour continuer à jouer sur <a href="'.$Url.'">easyBet.me</a>&nbsp;!</p>';
                $message.='<p>Les compteurs sont remis à zéro pour le mois de février !</p>';
                $message.='<p>Les prochains lots seront bientôt annoncés. Restez attentifs !</p>';
            
                /*
                $message.='<p>À gagner jusqu\'au 29 février 2024:</p>';
                $message.='<ul>';
                    $message.='<li>1<sup>er:</sup> <strong>50 crédits</strong></li>';
                    $message.='<li>2<sup>e:</sup> <strong>30 crédits</strong></li>';
                    $message.='<li>3<sup>e:</sup> <strong>10 crédits</strong></li>';
                $message.='</ul>';
                */
                $message.='<p>Bonne chance et à très vite sur <a href="'.$Url.'">easyBet.me</a></p>';
            $message.='</td>';
        $message.= '</tr>';
    $message.= '</table>';

    $sql = 'UPDATE easybet_users SET credits=credits+'.$credits.' WHERE id = '.$id;

    if (mail($Player['email'], $sujet, $message, $headers)) {
        $update = $db->prepare($sql);
        $update -> execute();
        echo $message;
    }

endif;
?>
</div>
</div>