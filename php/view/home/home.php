
<link href="../styles/_home.css" rel="stylesheet" type="text/css" />

<?php 

    ob_start(); 

    if(isset($ata['matches'])) { $data = $ata['matches']; }
    //var_dump($data);

    $_SESSION['login']=0; 

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
    <?php 
        if(isset($Event) && isset($Event['competition'])) {
            echo "<div class='message info'><p><i class='fa fa-info-circle'></i>";
            if(isset($Event)) { echo " " . $Event['competition'] . " du " .$Event['datedebut'] . " au " . $Event['datefin'] . "  -  " . $Event['description'] . ' <br />'; 
                if($_SESSION['login'] == 1 && $Event['datedebut'] <= date('Y-m-d')) { echo "<a href='/profile/cadeaux'>Participation</a>"; } else { echo "<a href='/login'>Inscrivez-vous/Connectez-vous</a>"; }
            }
            echo "</p></div>";
        }
     ?>
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

    $contenu = ob_get_clean();

    require_once "template.php";

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