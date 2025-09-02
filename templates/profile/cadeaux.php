<div class="content"><?

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    include 'templates/'.$page.'/commun.php';

    ?><div class="main">
        <h2><strong>Evènementielle</strong></h2>
        
        <div class="cadeau"><?php

            $currentDate = new DateTime(); // aujourd'hui
            $sevenDaysLater = (clone $currentDate)->modify('+7 days');

            // Formater les dates
            $nowStr = $currentDate->format('Y-m-d');
            $futureStr = $sevenDaysLater->format('Y-m-d');

            // Chercher un événement qui commence dans les 7 jours
            $Events = $db->query('SELECT * FROM easybet_events ORDER BY datedebut ASC LIMIT 1');
            $Events = $Events->fetch(PDO::FETCH_ASSOC);

            // Si on est au moins 7 jours avant le début
            if ($Events && !empty($Events['datedebut'])) {

                ?><h4><?= $Events['competition'] ?></h4>
                <h6>Du <?= $Events['datedebut'] ?> au <?= $Events['datefin'] ?></h6>
                <h5><?= $Events['cadeau'] ?></h5>
                <img src="<?= $Url ?>/images/events/<?= $Events['img'] ?>" alt="logo cadeau" />
                <p><?= $Events['description'] ?></p>
                <p>Vous gagner suivant votre position dans le classement :</p>
                <ul>
                    <li>1er  -> 20 coins</li>
                    <li>2ème -> 10 coins</li>
                    <li>3ème ->  5 coins</li>
                </ul>

                <?php

                $Game = $db->prepare('SELECT * FROM easybet_gamers WHERE id_user = :idUser AND id_event = :idEvent');
                $Game->bindParam(':idUser', $User['id']);
                $Game->bindParam(':idEvent', $Events['id']);
                $Game->execute();
                $Game = $Game->fetchAll(PDO::FETCH_ASSOC);

                if ($Events && !$Game && (new DateTime()) <= new DateTime($Events['datedebut'])) {
                    ?><form method="post" action="">
                        <input type="submit" value="Participer">
                    </form><?php
                } elseif ($Events && !$Game && (new DateTime()) > (new DateTime($Events['datedebut']))) {
                    ?><p>Désolé vous ne pouvez plus participer au tournois ! Les inscriptions sont fermée...<p><?php
                } elseif ($Events && $Game && (new DateTime()) <= (new DateTime($Events['datedebut']))) {
                    ?><p>Merci de votre participation !</p><?php
                } elseif ($Events && $Game && (new DateTime()) >= (new DateTime($Events['datedebut']))) {
                    ?>

                    <br />
                    <div class="main classement">
                        <h2><strong>Classement</strong></h2>
                        <p>Nb de participant(s) : <?= count($Game) ?></p>
            
                        <div class="datas">
                            <div class="head">
                                <div class="order">#</div>
                                <div class="pseudo">Joueur</div>
                                <div class="score">Points</div>
                            </div>
                            <?php

                                $j = 1;
                
                                $Classements = $db->prepare('SELECT * FROM easybet_gamers AS eg JOIN easybet_users AS eu ON eg.id_user = eu.id WHERE eg.id_event = :idEvent ORDER BY eg.event_points DESC ');
                                $Classements->bindParam(':idEvent', $Events['id']);
                                $Classements->execute();
                    
                                while ($Classement = $Classements->fetch()):
                                    ?>
                                        <div class="body" >
                                            <div class="order"><?=$j;?></div>
                                            <div class="pseudo"><strong><?=$Classement['pseudo'];?></strong></div>
                                            <div class="score"><?=$Classement['event_points'];?></div>
                                        </div>
                                    <?
                                    $j++;
                                endwhile;
                            ?>
                        </div>
                    </div>
                <?php
                } elseif ($Game) {
                    ?><p>Merci d'avoir participé !</p>
                    <p>Vous avez gagné <?= $Game['event_points'] ?> coins !</p>
                    <p>Vous pouvez les utiliser pour acheter des cadeaux dans la boutique.</p><?php
                } elseif ($Game && (new DateTime()) > (new DateTime($Events['datefin']))) {
                    $db->prepare('DELETE FROM easybet_gamers WHERE id_event = ?')->execute([$Events['id']]);
                }
            }
            else
            {
                ?>
                    <p>Aucun événement prévu dans les 7 prochains jours.</p>
                    <p>Vous pouvez participer à des événements pour gagner des cadeaux !</p>
                    <p>Il vous suffit de vous inscrire et de jouer pour gagner des points.</p>
                    <p>Les points sont calculés en fonction de votre classement dans le jeu.</p>
                    <p>Le classement est mis à jour régulièrement.</p>
                <?php
            } 
            ?>
        </div>
    </div>
</div>

<style>
    div.event, div.cadeau {
        display:flex;
        align-items:center;
        justify-content:center;
        flex-direction:column;
    }
    div.classement {
        margin-top: 50px;
    }
    img {
        width:50%;
    }
    p.date {
        font-size:0.8em;
    }
</style>

<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($User['id']) {
        $check = $db->prepare("SELECT id FROM easybet_gamers WHERE id_user = ? AND id_event = ?");
        $check->execute([$User['id'], $Events['id']]);
        if (!$check->fetch()) {
            $Gamer = $db->prepare("INSERT INTO easybet_gamers (id_event, id_user, event_points) VALUES (?, ?, ?)");
            if ($Gamer->execute([$Events['id'], $User['id'], 0])) {
                Redirection($Url.'/profile/cadeaux');
                exit;
            }
        }
    }
}

?>

 