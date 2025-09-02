<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

    $Users = $db->prepare('SELECT * FROM easybet_users WHERE id=?');
    $Users->execute([$User['id']]);
    $User = $Users->fetch();

    $Parties = $db->prepare('SELECT * FROM easybet_bets WHERE id_user=? ORDER BY date DESC');
    $Parties->execute([$User['id']]);
    $Parties = $Parties->fetchAll();

    $date = date('Y-m-d', time());

    foreach($Parties as $Partie) {
        
        $newDate = date("Y-m-d", strtotime($Partie['date']));
        if($date != $newDate) {
            $uri = $Url.'/matches-'.$newDate;
        } else {
            $uri = $Url.'/matches-'.$date;
        }
    
        $reqPrefs['http']['method'] = 'GET';
        $stream_context = stream_context_create($reqPrefs);
    
        $response = @file_get_contents($uri, false, $stream_context);
        if ($response === FALSE) {
            echo "<p>Informations indisponible !</p>";
            $matches = [];
            continue;
        } else {
            $matches = json_decode($response, true);
        }

        if(isset($array['matches']) && is_array($array['matches'])) {
            foreach($matches['matches'] as $match) {
                if($match['id'] == $Partie['id_game']) {

                            
                    if (!isset($match['score']) || empty($match)) {
                        echo "<p>Impossible de récupérer les données du match.</p>";
                        continue;
                    }

                    if (!isset($match['score']['winner'])) {
                        $PartieBet = '0';
                    } else {
                        switch ($match['score']['winner']) {
                            case 'HOME_TEAM': $PartieBet = '1'; break;
                            case 'AWAY_TEAM': $PartieBet = '2'; break;
                            case 'DRAW': $PartieBet = 'N'; break;
                            default: $PartieBet = '0';
                        }
                    }

                    echo $PartieBet;
                    $Parties = $db->prepare('UPDATE * FROM easybet_bets SET result = :result WHERE id_user = :idUser');
                    $Parties->bindParam([':idUser' => $User['id'], ':result' => $PartieBet]);
                    $Parties->execute();
                    
                    $points = 0;
                    $class = 'lost';
                    if ($match['score']['fullTime']['home']==$Partie['score_d'] && $match['score']['fullTime']['away']==$Partie['score_v']): 
                        $points = 3; 
                        $coins = 1;
                        $class = 'full'; 
                    elseif ($Partie['bet']==$PartieBet): 
                        $points = 1;
                        $coins = 0; 
                        $class = 'straight'; 
                    endif;

                    if ($Partie['result'] == null && $match['score']['winner'] != null && (new DateTime()) >= (new DateTime($match['utcDate']))->modify('+4 hours')) {

                        $parties = $db->prepare('UPDATE easybet_bets SET result = :result WHERE id = :betId');
                        $parties->execute([
                            ':result' => $PartieBet,
                            ':betId' => $Partie['id'],
                        ]);

                        $Game = $db->prepare('SELECT * FROM `easybet_gamers` WHERE id_user = :idUser');
                        $Game->bindParam(':idUser', $User['id']);
                        $Game->execute();

                        $update = $db->prepare('UPDATE easybet_users SET points = points + :points, coins = coins + :points WHERE id = :userId');
                        $update->execute([
                            ':points' => $points,
                            ':userId' => $User['id'],
                        ]);

                        if ($Game->rowCount() == 1) {

                            $updateGamer = $db->prepare('UPDATE easybet_gamers SET event_points = event_points + :coins WHERE id_user = :userId');
                            $updateGamer->execute([
                                ':coins' => $points,
                                ':userId' => $User['id'],
                            ]);



                        }
                    }
                }
            }
        }
        else {

        }
    }

    $Events = $db->query("SELECT * FROM easybet_events");   
    $Events->execute();         
    $Event = $Events->fetch(PDO::FETCH_ASSOC);

    if (($Events->rowCount() == 1) && (new DateTime() > new DateTime($Event['datefin']))) {

        $Classements = $db->prepare('SELECT * FROM easybet_gamers AS eg JOIN easybet_users AS eu ON eg.id_user = eu.id WHERE eg.id_event = :idEvent AND eg.event_points > 0 ORDER BY eg.event_points DESC ');
        $Classements->bindParam(':idEvent', $Event['id']);
        $Classements->execute();

        $Classement = $Classements->fetch();
        
        if ($Classement[0]) {
            update($Classement[0], 20);
        }

        if ($Classement[1]) {
            update($Classement[1], 10);
        }

        if ($Classement[2]) {
            update($Classement[2], 5);
        }

        $db->query("SET FOREIGN_KEY_CHECKS = 0");
        $db->query("TRUNCATE TABLE easybet_gamers");
        $db->query("SET FOREIGN_KEY_CHECKS = 1");                            

    }

    function update($a, $b) {
        $updateGamer = $db->prepare('UPDATE easybet_users SET coins = coins + :event_coins WHERE id_user = :userId');
        $updateGamer->execute([
            ':coins' => $b,
            ':userId' => $a['id_user'],
        ]);
        courriel();
    }

    function courriel() {
    
        $expediteur = 'contact@easybet.me';
        $email = $a["email"];
        $eol = "\r\n";
                        
        $headers = 'From: '.$expediteur.$eol;
        $headers.= 'Reply-To:'.$expediteur.$eol;
        $headers.= 'MIME-Version: 1.0'.$eol;
        $headers.= 'Content-Type: text/html; charset=utf-8'.$eol;
                            
        $objet   = 'Gagnant événement '.$Event['competition'].' de '.$Site['nom'];

        $msg = '
            <!DOCTYPE html>
            <html>
                <head>
                    <meta name="viewport" content="width=device-width, initial-scale=1">
                    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
                </head>
                <body>
                    <h1 style="font-size:48px;font-weight:bold;color:green;text-align:center;">
                        <i class="fas fa-futbol" style="font-size:48px;color:black;"></i>
                        &#xA0;&#xA0;easyBet.me&#xA0;&#xA0;
                        <i class="fas fa-futbol" style="font-size:48px;color:black;"></i>
                    </h1>
                    <br />
                    <div style="padding:50px 150px 0 150px;">
                        <p>Bonjour, '.$a['pseudo'].'</p>
                        <br />
                        <p>Félicitation, vous venez de remportez l\'événement '.$Event['competition'].' de <span style="font-weight:bold;color:green;">easyBet.me</span>.</p>
                        <br />
                        <p>Vous avez été le meilleur parieur de la période du '.$Event['datedebut'].' au '.$Event['datefin'].' et vous avez accumulé '.$a['event_points'].' pts .</p>
                        <p>Cela vous à permis de vous classé à la première place du classement de l\'événement '.$Event['competition'].'</p>
                        <br />
                        <p>Vous acquérez '.$b.' coins, qui vous permettra de faire des achats dasnla rubrique cadeaux de notre site '.$Site['nom'].'.</p>
                        <br />
                        <p>Merci de votre fidélité.</p>
                        <br />
                        <p style="margin-left:450px;">Merci de votre fidélité!</p>
                        <p style="margin-left:450px;">A très vite !</p>
                        <p style="margin-left:450px;">L\'équipe de <span style="font-weight:bold;color:green;">&#xA0;&#xA0;easyBet.me&#xA0;&#xA0;</span>.</p>
                    </div>
                    <br />
                    <br />
                    <br />
                    <br />
                    <h6 style="text-align:center;color:gray;">
                        Contactez-nous à l\'addresse suivante '.$expediteur.'
                        <br />
                        <br />
                        <span style="font-weight:bold;color:green;">
                            <i class="fas fa-futbol" style="font-size:12px;color:black;"></i>
                                &#xA0;&#xA0;easyBet.me&#xA0;&#xA0;
                            <i class="fas fa-futbol" style="font-size:12px;color:black;"></i>
                        </span>
                    </h6>

                </body>
                </html>
        ';

        // Envoi de l'email avec pièce jointe
        $boundary = uniqid('np');
        $headers = "From: ".$expediteur."\r\n";
        $headers .= "Reply-To: ".$expediteur."\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: multipart/mixed; boundary=\"$boundary\"\r\n";
        $message = "--$boundary\r\n";
        $message .= "Content-Type: text/html; charset=UTF-8\r\n\r\n";
        $message .= $msg ."\r\n\r\n";
        $message .= "--$boundary\r\n";
        $message .= "Content-Type: application/pdf; name=\"$fileName\"\r\n";
        $message .= "Content-Disposition: attachment; filename=\"$fileName\"\r\n";
        $message .= "Content-Transfer-Encoding: base64\r\n\r\n";
        $message .= $fileContent . "\r\n\r\n";
        $message .= "--$boundary--";

        mail($email, $objet, $message, $headers);

    }


?>