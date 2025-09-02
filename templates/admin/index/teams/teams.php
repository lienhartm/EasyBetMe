<div class="team">
    <p><strong>Equipes</strong></p>
    <ul>
    <?
        $Equipes = $db->query('SELECT * FROM easybet_teams ORDER BY team');
        while ($Equipe = $Equipes->fetch()) {
            echo '<li><a href="'.$Url.'/admin/team/'.$Equipe['id'].'"><img src="'.$Url.'/images/teams/'.$Equipe['logo'].'" /> '.$Equipe['team'].'</a></li>';
        }
    ?>
    </ul>
</div>