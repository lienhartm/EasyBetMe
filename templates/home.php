<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


//unset($_SESSION['message']);

$total = 0;

try {
    $Paris = $db->query('SELECT * FROM easybet_bets WHERE result IS NULL AND DATE(date) != CURDATE()');
    $Paris = $Paris->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $errorMessage = "Erreur lors de la requête : " . $e->getMessage();
    die($errorMessage);
}

try {
    $currentDate = date('Y-m-d');
    $Events = $db->query('SELECT * FROM easybet_events ORDER BY datedebut ASC LIMIT 1');
    $Events = $Events->fetch(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $errorMessage = "Erreur lors de la requête : " . $e->getMessage();
    die($errorMessage);
}

try {    
    $Gamers = $db->query('SELECT * FROM easybet_gamers ORDER BY event_points DESC');
    $Gamers = $Gamers->fetchAll(PDO::FETCH_ASSOC);
    if (isset($Gamers) && !empty($Gamers)) {
    $rank = 1;
    foreach ($Gamers as $key => &$gamer) {

        $gamer['rank'] = $rank;

        if (isset($Gamers[$key + 1]) && $Gamers[$key + 1]['event_points'] == $gamer['event_points']) {
            continue;
        }

        $rank++;
    }
}
} catch (Exception $e) {
    $errorMessage = "Erreur lors de la requête : " . $e->getMessage();
    die($errorMessage);
}

try {

    if ($Paris) {

        foreach($Paris as $Pari) {

            $date = date("Y-m-d", strtotime($Pari['date']));

            $path = __DIR__ . "/cron-tab-1/data/matches-" . date("Y-m-d", strtotime($Pari['date'])) . ".json";
        
            if (!file_exists($path)) {
                $errorMessage = "Le fichier n'existe pas : " . $path;
                continue;
            }
            
            $myfile = fopen($path, "r");

            if (!$myfile) {
                $fileErrorMessage = "\nImpossible d'ouvrir le fichier $path !";
                return;
            }

            $file = fread($myfile, filesize($path));
            fclose($myfile);
            $data = json_decode($file, true);

            $data = $data['matches'];
            
            if (json_last_error() !== JSON_ERROR_NONE) {
                $errorMessage = 'Erreur lors du décodage du JSON : ' . json_last_error_msg();
                return;
            }

            if ($Pari['result'] == null) {
                $points = '';

                foreach($data as $a) {

                    if (($a['score']['winner'] == null)) {
                        continue;
                    }

                    if ($a['id'] != $Pari['id_game']) {
                        continue;
                    }

                    switch ($a['score']['winner']) {
                        case 'HOME_TEAM': $PariBet = '1'; break;
                        case 'AWAY_TEAM': $PariBet = '2'; break;
                        case 'DRAW': $PariBet = 'N'; break;
                        default: $PariBet = null; break;
                    }

                    $update = $db->prepare('UPDATE easybet_bets SET result = :result WHERE id_game = :idGame');
                    $update->execute([':idGame' => $Pari['id_game'], ':result' => $PariBet]);

                    if ($Pari['bet'] === $PariBet) {
                        $points = 1;
                    }
                    elseif (($Pari['score_d'] === $a['score']['fullTime']['home']) && ($Pari['score_v'] === $a['score']['fullTime']['away'])) {
                        $points = 3;
                    }
                    else {
                        $points = 0;
                    }

                    $update = $db->prepare('UPDATE easybet_users SET points = points + :points, coins = coins + :points WHERE id = :userId');
                    $update->execute([
                        ':points' => $points,
                        ':userId' => $Pari['id_user'],
                    ]);

                    if($Events) {
                        if (date('Y-m-d') >= $Events['datedebut'] && date('Y-m-d') <= $Events['datefin'] && $Pari['date'] >= $Events['datedebut'] && $Pari['date'] <= $Events['datefin']) { // Si la date du pari est dans l'intervalle de l'événement date("Y-m-d", strtotime($Pari['date'])
                            
                            $updateGamer = $db->prepare('UPDATE easybet_gamers SET event_points = event_points + :coins WHERE id_user = :idUser');
                            $updateGamer->execute([
                                ':coins' => $points,
                                ':idUser' => $Pari['id_user'],
                            ]);
                        }
                    }

                    $PariBet = null;
                    $points = null;

                }
            }
        }
    }

} catch (Exception $e) {
    $errorMessage = "Erreur : " . $e->getMessage();
    die($errorMessage);
}

if (isset($Events) && !empty($Events)) {
    if(date('Y-m-d') > $Events['datedebut']) {
        $gains = [ 1000, 500, 250, 100 ];
        foreach($gains as $gain) {
                
            for($i = 0; $i < 4; ++$i) {
                foreach($Gamers as $Gamer) {
                    if($Gamer['rank'] == $i) {
                        $update = $db->prepare('UPDATE easybet_gamers SET event_points = event_points + :coins WHERE id_user = :idUser');
                        $update->execute([
                            ':coins' => $gains[$i],
                            ':idUser' => $Gamer['id_user'],
                        ]);
                    }
                }
            }
        }

        // Supprimer les GAMERS
        $delete = $db->prepare('DELETE FROM easybet_gamers');
        $delete->execute();
        // Supprimer l' event
        $deleteEvent = $db->prepare('DELETE FROM easybet_events WHERE datefin < :datefin');
        $deleteEvent->execute([':datefin' => date('Y-m-d')]);
        // Supprimer les paris < 15 jours
        $deletePari = $db->prepare('DELETE FROM easybet_bets WHERE date < :date');
        $deletePari->execute([':date' => date('Y-m-d', strtotime('-15 days'))]);

    }
}



if($_SESSION['login']==1) {

    $date = date('Y-m-d');
    $Check = $db->prepare('SELECT * FROM easybet_bets WHERE id_user=? AND date=?');
    $Check->execute([$User['id'], $date]);
    $nbCheck = $Check->rowCount();
    $CheckParty = $Check->fetchAll();
    $Check_idGame = array_column($CheckParty, 'id_game');
    $sleep = 0;
    if ($sleep==1) {
        echo '<div class="nogame">easyBet est en maintenance et revient bientôt avec plus de fonctionnalités et plus de cadeaux.<br />En attendant suivez-bous sur Facebook...</div>';
    }

}

    // Récupérer l'événement qui commence dans les 7 jours
    $currentDate = new DateTime(); // aujourd'hui
    $sevenDaysLater = (clone $currentDate)->modify('+7 days');

    // Formater les dates
    $nowStr = $currentDate->format('Y-m-d');
    $futureStr = $sevenDaysLater->format('Y-m-d');

    // Chercher un événement qui commence dans les 7 jours
    $Event = $db->prepare('
        SELECT * FROM easybet_events WHERE datedebut >= :now AND datedebut <= :future
        ORDER BY datedebut ASC
        LIMIT 1
    ');
    $Event->execute([
        'now' => $nowStr,
        'future' => $futureStr
    ]);
    $Event = $Event->fetchAll(PDO::FETCH_ASSOC);

    // Récupérer l'événement actuel
    $currentEvent = $db->query('SELECT * FROM easybet_events');
    $currentEvent = $currentEvent->fetch(PDO::FETCH_ASSOC);

?>

<div class="home">

    <!-- afficher les messages -->
    <div id="message-container">
        <?php if($_SESSION['login'] == 1 && isset($_SESSION['message'])) { echo $_SESSION['message'];} ?>
    </div>

    <div id="message-evenement">
    <?php
    // Afficher l'événement actuel s'il existe
    if(isset($currentEvent) && $currentEvent != $Event) {
        echo "<div class='message info'><p><i class='fa fa-info-circle'></i>";
        if(isset($currentEvent)) { echo ' ' . $currentEvent['competition'] . ' du ' .$currentEvent['datedebut'] . ' au ' . $currentEvent['datefin'] . '  -  ' . $currentEvent['description'] . ' <br />';} 
        if(isset($_SESSION['login']) && $_SESSION['login'] == 1 && $currentEvent['datedebut'] >= date('Y-m-d')) { echo "<a href='/profile/cadeaux'>Participation</a>"; }
        echo '</p></div>';
    }

    ?>
    </div>
        
    <div id='message-evenement'>
    <!-- Afficher l'événement dans les 7 jours -->
    <?php if(isset($Event) && isset($Event['competition'])) {
        echo "<div class='message info'><p><i class='fa fa-info-circle'></i>";
        if(isset($Event)) { echo " " . $Event['competition'] . " du " .$Event['datedebut'] . " au " . $Event['datefin'] . "  -  " . $Event['description'] . ' <br />'; 
            if($_SESSION['login'] == 1 && $Event['datedebut'] <= date('Y-m-d')) { echo "<a href='/profile/cadeaux'>Participation</a>"; } else { echo "<a href='/login'>Inscrivez-vous/Connectez-vous</a>"; }}
        echo "</p></div>";
    } ?>
    </div>

    <div class="games">
        <div class="head">
            <h2><strong>MATCHS DU JOUR</strong></h2>
        </div>
        <br />
        <div style="display:flex;">
            <div style="display:flex;margin:auto;" id="competition-container"></div>
        </div>
        <div id="matches-container" >
            <?php if($_SESSION['login']!=1): ?>
            <h3 style='text-align:center'>Bienvenue sur le site EasyBet !</h3>
            <?php endif; ?>
        </div>
    </div>

</div>

<?php

    $path = __DIR__ . "/cron-tab-1/data/matches-" . date('Y-m-d', time()) . ".json";
    
    if (!file_exists($path)) {
        die("<p style='text-align:center;'>Veuillez patientez jusqu'à la mise à disposition des matches du jour, cela ne devrai pas tarder.<br />Oops un petit problème, veuillez contactez l'administrateur !<p>");
    }

    $myfile = fopen($path, "r") or die("Impossible d'ouvrir le fichier !");
    $file = fread($myfile, filesize($path));
    fclose($myfile);

    $data = json_decode($file, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        die('Erreur lors du décodage du JSON : ' . json_last_error_msg());
    }

    $data = $data['matches'];
    
?>
<script>
        
    document.addEventListener('DOMContentLoaded', function() {        
        createCompetitionSearch();
        fetchMatches();
    });

    var messageContainer = document.getElementById('message-container');
    
    // Si un message existe
    if (messageContainer && messageContainer.innerHTML.trim() !== "") {
        // Masquer le message après 5 secondes
        setTimeout(function() {
            messageContainer.style.display = 'none';
        }, 5000); // 5000 millisecondes = 5 secondes
    }

    function fetchMatches() {

        const data = <?php echo json_encode($data); ?>;

    
        const session = <?= json_encode($_SESSION['login']); ?>;

        console.log(session);


        if (!data || data.length === 0) {
            document.getElementById('competition-container').innerHTML = `<h2>Aucun matches aujourd\'hui !<br />Mais vous pouvez toujours jouez au ${session ? '<a href="/penalty">mini-jeu de penalty !</a>' : 'mini-jeu de penalty !'}<br /><br />${!session ? '<a href="/login">Inscrivez-vous/Connectez-vous</a>' : ''}</h2>`;
            document.getElementById('matches-container').innerHTML = ``;
            return;
        }

        displayCompetitions(data);

        let competition = document.getElementById('competition').value ? document.getElementById('competition').value : '';
        let filteredMatches;

        if (competition != 'all') {
            filteredMatches = Object.values(data).filter(match => match.competition.code === competition);
        } else {
            filteredMatches = Object.values(data);
        }

        displayMatches(filteredMatches);
    }

    function createCompetitionSearch() {
    
        const container = document.getElementById('competition-container');

        const boldText = document.createElement('b');
        boldText.textContent = "Recherche par compétition";
        boldText.style.marginRight = "20px";

        const form = document.createElement('form');
        form.method = "GET";
        form.action = "";

        const select = document.createElement('select');
        select.name = "competition";
        select.id = "competition";
        select.onchange = fetchMatches;

        const defaultOption = document.createElement('option');
        defaultOption.value = "all";
        defaultOption.textContent = " --- Compétitions --- ";
        select.appendChild(defaultOption);
    
        form.appendChild(select);
        container.appendChild(boldText);
        container.appendChild(form);

    }

    function displayCompetitions(matches) {

        let competitionSelect = document.getElementById('competition');
        let selectedValue = competitionSelect.value || '';  // Sauvegarde de la sélection actuelle
        let displayedCompetitions = new Set();
        
        // Créer l'option par défaut
        const defaultOption = document.createElement('option');
        defaultOption.value = "all";
        defaultOption.textContent = " --- Compétitions --- ";
        
        // Vider le select sans supprimer l'option par défaut
        competitionSelect.innerHTML = '';
        competitionSelect.appendChild(defaultOption);

        // Afficher les compétitions disponibles sans duplicata
        for (let match in matches) {
            let competitionName = matches[match].competition.code;

            if (!displayedCompetitions.has(competitionName)) {
                let option = document.createElement('option');
                option.value = competitionName;
                option.textContent = matches[match].competition.name + ' - ' + matches[match].area.code;
                competitionSelect.appendChild(option);
                displayedCompetitions.add(competitionName);
            }
        };

        // Rétablir la sélection précédente
        if (selectedValue && competitionSelect.querySelector(`option[value="${selectedValue}"]`)) {
            competitionSelect.value = selectedValue;
        }
    }


    // Fonction pour afficher les matchs
    function displayMatches(matches) {
        
        const container = document.getElementById('matches-container');
        container.innerHTML = '';
        if (!matches || Object.keys(matches).length === 0) {
            container.innerHTML = '<div class="nogame">Pas de match aujourd\'hui !</div>';
        } else {         
            for (let match in matches) {
                container.innerHTML += generateMatchHTML(matches[match]);
            };
        }
    }

    // Fonction pour générer le HTML pour chaque match
    function generateMatchHTML(match) {
        const homeTeam = match.homeTeam;
        const awayTeam = match.awayTeam;
        const competition = match.competition;

        return `
            <div class="game">
                <p class="date"><span class="icon">&#xe94e;</span>${new Date(match.utcDate).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })}</p>
                <p class="competition">
                    <img src="${competition.emblem}" />
                    <strong>${competition.name}</strong>
                </p>
                <div class="teams">
                    <div class="inline team">
                        <div class="logo">
                            <img src="${homeTeam.crest}" alt="${homeTeam.name}" />
                        </div>
                        <p><strong>${homeTeam.name}</strong></p>
                    </div>
                    <div class="inline form">
                        ${generateBetForm(match)}
                    </div>
                    <div class="inline team">
                        <div class="logo">
                            <img src="${awayTeam.crest}" alt="${awayTeam.name}" />
                        </div>
                        <p><strong>${awayTeam.name}</strong></p>
                    </div>
                </div>
                ${logged(match)}
            </div>
        `;
    }

    let userIsLoggedIn = <?php echo $_SESSION['login']==1 ? 'true' : 'false'; ?>;
    let Check_idGame = <?php echo isset($Check_idGame) ? json_encode($Check_idGame) : '[]' ?>;
    let CheckParty = <?php echo isset($CheckParty) ? json_encode($CheckParty) : '[]' ?>;

    function generateBetForm(match) {
        let pari ='';
        if(Check_idGame && CheckParty) {
            if (Check_idGame.includes(match.id)) {
                CheckParty.forEach(Check => {
                    if (Check.id_game === match.id) {
                        pari =`
                            <div class="team">
                                <p class="intro">Votre pronostic :</p>
                                <p class="score <?=$class;?>">${Check.score_d} - ${Check.score_v}</p>
                            </div>
                        `;
                    }
                });
                return pari;
            }
            else if (!Check_idGame.includes(match.id)) {
                if (userIsLoggedIn && new Date(match.utcDate) > new Date()) {
                    return `
                        <form class="bet" method="POST" action="/bet">
                            <input type="hidden" name="id_game" value="${match.id}" />
                            <input type="hidden" name="id_domicile" value="${match.homeTeam.id}" />
                            <input type="hidden" name="id_visiteur" value="${match.awayTeam.id}" />
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
                    `;
                }            
                else {
                    return '<p class="empty">0</p>';
                }
            }
        }
    }

    

    function logged(match) {
        if(!userIsLoggedIn) {
            return `
                <div class='closed'>
                    <div class='picto'>
                        <span class='icon'>&#xea0c;</span>
                    </div>
                    <div class='msg'>
                        <p>Vous devez être connecté pour jouer.<br /><a href=''>Se connecter / Créer un compte</a>.</p>
                    </div>
                </div>
            `;
        }
        else if (userIsLoggedIn && new Date(match.utcDate) < new Date()) {
            return `
                <div class='closed'>
                    <div class='picto'>
                        <span class='icon'>&#xea0c;</span>
                    </div>
                    <div class='msg'>
                        <p>Le match a commencé.<br />Vous ne pouvez plus faire de pronostic sur ce match</p>
                    </div>
                </div>
            `;
        }
        else {
            return `<div></div>`;
        }
    }

    setTimeout(function() {
        document.getElementById('message-evenement').style.display = 'none';
    }, 20000);
    
</script>

<style>

    .nogame {
        font-size:24px;
        text-align:center;
        font-weight:bold;
    }

    #matches-container {
        width: 800px;
        margin: auto;
    }

    @media only screen and (max-width: 600px) {
        #matches-container {
            width: 100%;
        }
        #message-container {
            width: 100%;
        }
        div.message {
            width: 100%;
        }
    }
    
</style>
