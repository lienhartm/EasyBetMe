<link href="../styles/_competition.css" rel="stylesheet" type="text/css" />
<?php

// temporisation de sortie
    ob_start();

    if(!isset($competitions)) { echo "Aucune compétition trouvée."; }
    if(!isset($matches)) { echo "Aucun match trouvé."; }
    if(!isset($standings)) { echo "Aucun classement trouvé."; }
    if(!isset($scorers)) { echo "Aucun buteur trouvé."; }

    $matches_finished = [];
    $matches_upcoming = [];
    $items = 10;

    foreach($matches['matches'] as $match) {
        if ($match['status'] === 'FINISHED') {
            $matches_finished[] = $match;
        } 
        else {
                $matches_upcoming[] = $match;
        }
    }
    
    usort($matches_finished, function($a, $b) {
        return strtotime($b['utcDate']) - strtotime($a['utcDate']);
    });

?>

<div>
    <h2 class="titre align"><img src='<?= $competitions['emblem'] ?>' alt='emblem' width='100px' height='100px' />  <?= $competitions['name'] ?></h2>
    <div class="ligne">
        <div class="info">
            <img src='<?= $competitions['area']['flag'] ?>' alt='area flag' width='50px' height='50px' />
            <h3><?= $competitions['area']['name'] ?></h3>
        </div>
        <h3><b>Journée: </b><?= $competitions['currentSeason']['currentMatchday'] ?></h3>
        <h3><b>Saison: </b><?= $competitions['currentSeason']['startDate'] ?> - <?= $competitions['currentSeason']['endDate'] ?></h3>
    </div>
</div>

<div class="align_info">

    <a href="#" class="nav" data-target="gagnants">Voir les gagnants</a>
    <a href="#" class="nav" data-target="recent-matches">Voir les matches récents</a>
    <a href="#" class="nav" data-target="upcoming-matches">Voir les matches à venir</a>
    <a href="#" class="nav" data-target="equipes">Voir le classement équipes</a>
    <a href="#" class="nav" data-target="joueurs">Voir le classement joueurs</a>

</div>

<div class="grid-container">
    <div class="section" id="gagnants">
        <div class="table">
            <h3>Gagnant :</h3>
            <table>
                <thead>
                    <tr>
                        <th style="width:200px;">Saison</th>
                        <!--<th>Journées</th>-->
                        <th style="width:400px;">Gagnant</th>
                    </tr>
                </thead>
                <tbody id="competition-winners"></tbody>
            </table>
            <div class="pagination" id="winner-pagination"></div>
        </div>
    </div>

    <div class="section" id="recent-matches">
        <div class="table">
            <h3>Matches récents:</h3>
            <table>
                <thead>
                    <tr>
                        <th style='width:90px;text-align:left;'>Date</th>
                        <th style='width:200px;'>Matches</th>
                        <th style='width:10px;'></th>
                        <th style='width:200px;'></th>
                        <th style='width:50px;text-align:left;'>Scores</th>
                    </tr>
                </thead>
                <tbody id="recent-results"></tbody>
            </table>
            <div class="pagination" id="recent-pagination"></div>
        </div>
    </div>

    <div class="section" id="upcoming-matches">
        <div class="table">
            <h3>Matches à venir:</h3>
            <table>
                <thead>
                    <tr>
                        <th style='width:90px;text-align:left;'>Date</th>
                        <th style='width:200px;text-align:right;'>Matches</th>
                        <th style='width:10px;'></th>
                        <th style='width:200px;'></th>
                    </tr>
                </thead>
                <tbody id="upcoming-results"></tbody>
            </table>
            <div class="pagination" id="upcoming-pagination"></div>
        </div>
    </div>

    <div class='section' id="equipes">
        <div class='table'>
            <h3>Classement équipes:</h3>
            <table>
                <thead>
                    <tr>
                        <th style='width:5px;'>Pos.</th>
                        <th style='width:25px;'>Equipe</th>
                        <th style='width:5px;'>J.</th>
                        <th style='width:5px;'>G.</th>
                        <th style='width:5px;'>N.</th>
                        <th style='width:5px;'>P.</th>
                        <th style='width:5px;'>Pts</th>
                        <th style='width:5px;'>ButT</th>
                        <th style='width:5px;'>ButR</th>
                        <th style='width:5px;'>ButDiff</th>
                    </tr>
                </thead>
                <tbody>
                    <?php

                        foreach($standings['standings'][0]['table'] as $standing) {
                            echo "
                                <tr>
                                    <td style='text-align:center;'>".$standing['position']."</td>
                                    <td style='margin-left:10px;'>
                                        <img src='".$standing['team']['crest']."' alt='image club' width='20px' height='20px' />
                                        <span class='name'>".$standing['team']['name']."</span>
                                    </td>
                                    <td style='text-align:center;'>".$standing['playedGames']."</td>
                                    <td style='text-align:center;'>".$standing['won']."</td>
                                    <td style='text-align:center;'>".$standing['draw']."</td>
                                    <td style='text-align:center;'>".$standing['lost']."</td>
                                    <td style='text-align:center;'>".$standing['points']."</td>
                                    <td style='text-align:center;'>".$standing['goalsFor']."</td>
                                    <td style='text-align:center;'>".$standing['goalsAgainst']."</td>
                                    <td style='text-align:center;'>".$standing['goalDifference']."</td>
                                </tr>
                            ";
                        }

                    ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class='section' id="joueurs">
            <div class='table'>
                <h3>Classement joueurs:</h3>
                <table>
                    <thead>
                        <tr>
                            <th style='width:50px;'>Pos.</th>
                            <th style='width:200px;'>Joueurs</th>
                            <th style='width:50px;'>J.</th>
                            <th style='width:50px;'>But</th>
                            <th style='width:50px;'>A</th>
                            <th style='width:50px;'>P.</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php

                            $k = 0;

                            foreach($scorers['scorers'] as $scorer) {

                                echo "
                                    <tr>
                                        <td style='text-align:center;width:20px;'>".++$k."</td>
                                        <td style='margin-left:20px;width:100px;'>
                                            <img src='".$scorer['team']['crest']."' alt='image équipe' width='20px' height='20px' />
                                            ".$scorer['player']['firstName']." ".$scorer['player']['lastName']."
                                        </td>
                                        <td style='text-align:center;'>" .($scorer['playedMatches'] ? $scorer['playedMatches'] : '0')."</td>
                                        <td style='text-align:center;'>".($scorer['goals'] ? $scorer['goals'] : '0')."</td>
                                        <td style='text-align:center;'>".($scorer['assists'] ? $scorer['assists'] : '0')."</td>
                                        <td style='text-align:center;'>".($scorer['penalties'] ? $scorer['penalties'] : '0')."</td>
                                    </tr>
                                ";
                            }

                        ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="retour">
        <a href='#' >Retour</a>
    </div>
</div>

<?php

    $contenu = ob_get_clean();

    require_once "template.php";

?>

<script>

    document.querySelectorAll('.section').forEach(container => container.style.display = 'none');

    function voir(element) {
        const targetId = element.dataset.target;

        // Cacher toutes les sections
        document.querySelectorAll('.section').forEach(section => {
            section.style.display = 'none';
        });

        // Afficher la bonne section
        const sectionToShow = document.getElementById(targetId);
        if (sectionToShow) {
            sectionToShow.style.display = 'block';
        }
    }

    // Attacher les événements au chargement
    document.querySelectorAll('.nav').forEach(link => {
        link.addEventListener('click', function(event) {
            event.preventDefault();
            voir(this);
        });
    });

 
    let competitionWinners = <?php echo json_encode($competitions['seasons']); ?>;

    const validWinners = competitionWinners.filter(season => season.winner != null);

    let recentMatches = <?php echo json_encode($matches_finished); ?>;
    let upcomingMatches = <?php echo json_encode($matches_upcoming); ?>;

    const itemsPerPage = 10;

    function formatDate(utcDate) {
        const date = new Date(utcDate);
        const day = String(date.getDate()).padStart(2, '0');
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const year = date.getFullYear();
        const hours = String(date.getHours()).padStart(2, '0');
        const minutes = String(date.getMinutes()).padStart(2, '0');

        return `${day}/${month}/${year}, ${hours}h${minutes}`;
    }

    function yearSeason(utcDate) {

        const date = new Date(utcDate);
        const year = date.getFullYear();

        return `${year}`;
    }

    function displayCompetitionWinners(page) {
        const resultsContainer = document.getElementById('competition-winners');
        resultsContainer.innerHTML = '';

        const startIndex = (page - 1) * itemsPerPage;
        const endIndex = Math.min(startIndex + itemsPerPage, validWinners.length);
        
        for (let i = startIndex; i < endIndex; i++) {
            const season = validWinners[i];

            if(season.startDate && season.endDate && season.winner != null) {
                
                const matchDiv = document.createElement('tr');
                //matchDiv.className = 'match';
                matchDiv.innerHTML = `
                    <td class='align'>${yearSeason(season.startDate)} - ${yearSeason(season.endDate)}</td>
                    <td class='align'>
                        <img src='${season.winner.crest}' alt='logo winner' width='20px' height='20px' />
                        ${season.winner.name}
                    </td>
                `;
                resultsContainer.appendChild(matchDiv);
            }
        }

        displayWinnerPagination(page);
    }

    function displayWinnerPagination(page) {
        const paginationContainer = document.getElementById('winner-pagination');
        paginationContainer.innerHTML = '';

        const totalPages = Math.ceil(validWinners.length / itemsPerPage);
        
        if (page > 1) {
            const prevButton = document.createElement('button');
            prevButton.innerText = 'Précédent';
            prevButton.onclick = () => displayCompetitionWinners(page - 1);
            paginationContainer.appendChild(prevButton);
        }

        if (page < totalPages) {
            const nextButton = document.createElement('button');
            nextButton.innerText = 'Suivant';
            nextButton.onclick = () => displayCompetitionWinners(page + 1);
            paginationContainer.appendChild(nextButton);
        }
    }

    function displayRecentMatches(page) {
        const resultsContainer = document.getElementById('recent-results');
        resultsContainer.innerHTML = '';

        const startIndex = (page - 1) * itemsPerPage;
        const endIndex = Math.min(startIndex + itemsPerPage, recentMatches.length);
        
        for (let i = startIndex; i < endIndex; i++) {
            const match = recentMatches[i];
            const matchDiv = document.createElement('tr');
            matchDiv.className = 'match';
            matchDiv.innerHTML = `
                <td style='width:60px;'>${formatDate(match.utcDate)}</td><td style='text-align:right;'><img src='${match.homeTeam.crest}' alt='logo homeTeam' width='20px' height='20px' />${match.homeTeam.name}</td><td style='width:10px;text-align:center;'> - </td><td><img src='${match.awayTeam.crest}' alt='logo homeTeam' width='20px' height='20px' />${match.awayTeam.name}</td><td style='text-align:center;width:30px;'>${match.score.fullTime.home}:${match.score.fullTime.away}</td>
            `;
            resultsContainer.appendChild(matchDiv);
        }

        displayRecentPagination(page);
    }

    function displayRecentPagination(page) {
        const paginationContainer = document.getElementById('recent-pagination');
        paginationContainer.innerHTML = '';

        const totalPages = Math.ceil(recentMatches.length / itemsPerPage);
        
        if (page > 1) {
            const prevButton = document.createElement('button');
            prevButton.innerText = 'Précédent';
            prevButton.onclick = () => displayRecentMatches(page - 1);
            paginationContainer.appendChild(prevButton);
        }

        if (page < totalPages) {
            const nextButton = document.createElement('button');
            nextButton.innerText = 'Suivant';
            nextButton.onclick = () => displayRecentMatches(page + 1);
            paginationContainer.appendChild(nextButton);
        }
    }

    function displayUpcomingMatches(page) {
        const resultsContainer = document.getElementById('upcoming-results');
        resultsContainer.innerHTML = '';

        const startIndex = (page - 1) * itemsPerPage;
        const endIndex = Math.min(startIndex + itemsPerPage, upcomingMatches.length);
        
        for (let i = startIndex; i < endIndex; i++) {
            const match = upcomingMatches[i];
            const matchDiv = document.createElement('tr');
            matchDiv.className = 'match';
            matchDiv.innerHTML = `
                <td>${formatDate(match.utcDate)}</td><td style='text-align:right;'><img src='${match.homeTeam.crest}' alt='logo homeTeam' width='20px' height='20px' />${match.homeTeam.name}</td><td style='width:10px;text-align:center;'> - </td><td><img src='${match.awayTeam.crest}' alt='logo awayTeam' width='20px' height='20px' />${match.awayTeam.name}</td>
            `;
            resultsContainer.appendChild(matchDiv);
        }

        displayUpcomingPagination(page);
    }

    function displayUpcomingPagination(page) {
        const paginationContainer = document.getElementById('upcoming-pagination');
        paginationContainer.innerHTML = '';

        const totalPages = Math.ceil(upcomingMatches.length / itemsPerPage);
        
        if (page > 1) {
            const prevButton = document.createElement('button');
            prevButton.innerText = 'Précédent';
            prevButton.onclick = () => displayUpcomingMatches(page - 1);
            paginationContainer.appendChild(prevButton);
        }

        if (page < totalPages) {
            const nextButton = document.createElement('button');
            nextButton.innerText = 'Suivant';
            nextButton.onclick = () => displayUpcomingMatches(page + 1);
            paginationContainer.appendChild(nextButton);
        }
    }

    displayCompetitionWinners(1);
    displayRecentMatches(1);
    displayUpcomingMatches(1);
</script>
