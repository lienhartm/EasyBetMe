<div class="content">
    <?php
        include 'templates/'.$page.'/commun.php';
    ?>

    <div class="main classement">
        <h2><strong>Pronostics</strong></h2>

        <div class="datas">
            <div class="head">
                <div class="date">Date</div>
                <div class="game">Match</div>
                <div class="point">Points</div>
            </div>
            <?php
            
                $date = date('Y-m-d', time());

                $Users = $db->prepare('SELECT * FROM easybet_users WHERE id=?');
                $Users->execute([$User['id']]);
                $User = $Users->fetch();
                
                $Parties = $db->prepare('SELECT * FROM easybet_bets WHERE id_user=? ORDER BY date DESC');
                $Parties->execute([$User['id']]);
                $Partie = $Parties->fetchAll(PDO::FETCH_ASSOC);

                $date = '';
                foreach($Partie as $partie) {

                    //print_r($partie);

                    $path = "/homepages/18/d864215150/htdocs/monwebpro.com/sites/easybet/templates/cron-tab-1/data/matches-" . date('Y-m-d', strtotime($partie['date'])) . ".json";
                    $myfile = fopen($path, "r") or die("Unable to open file!");
                    $file = fread($myfile, filesize($path));
                    fclose($myfile);
                    $data = json_decode($file, true);

                    foreach($data as $match) {
                        
                        if($match['id'] == $partie['id_game']) {
                            
                            if (!isset($match['score']) || empty($match)) {
                                echo "<p>Impossible de récupérer les données du match.</p>";
                                continue;
                            }

                            ?>
                            <div class="body">
                                <div class="date">
                                    <p class="date"><span class="icon">&#xe94e;</span><?=date("Y-M-d H:i", strtotime($match['utcDate']))?></p>
                                </div>
                                <div class="game">
                                    <div class="team">
                                        <div class="logo">
                                            <img src="<?=$match['homeTeam']['crest'];?>" alt="<?=$match['homeTeam']['name'];?>" />
                                        </div>
                                        <p><?=$match['homeTeam']['name'];?></p>
                                    </div>
                                    <div class="scores">
                                        <p class="intro">Résultat final:</p>
                                        <? if ($match['score']['winner']!=null): ?>
                                        <p class="score real"><?=$match['score']['fullTime']['home'].'-'.$match['score']['fullTime']['away'];?></p>
                                        <? else: ?>
                                        <p class="score real"><span>En cours...</span></p>
                                        <? endif; ?>
                                        <p class="intro">Votre pronostic:</p>
                                        <p class="score <?=$class;?>"><?=$partie['score_d'].'-'.$partie['score_v'];?></p>
                                    </div>
                                    <div class="team">
                                        <p><?=$match['awayTeam']['name'];?></p>
                                        <div class="logo">
                                            <img src="<?=$match['awayTeam']['crest'];?>" alt="<?=$match['awayTeam']['name'];?>" />
                                        </div>
                                    </div>
                                </div>
                                <div class="points">
                                    <?php
                                        if ($partie['result']!=null) {
                                            $points = '';
                                            if ( ($partie['bet'] === $partie['result']) && ($partie['score_d'] === $match['score']['fullTime']['home']) && ($partie['score_v'] === $match['score']['fullTime']['away']) ) { echo "3 pts"; }
                                            elseif( $partie['bet'] === $partie['result'] ) { echo '1 pts'; }
                                            else { echo "0 pts"; }
                                        }
                                    ?>
                                </div>
                            </div>
                        <?php

                            }
                        }

                        //echo $partie['bet'] ." - ". $partie['result'] ." / ". $partie['score_d'] ." - ". $match['score']['fullTime']['home'] ." / ". $partie['score_v'] ." - ". $match['score']['fullTime']['away'];
                }
                ?>
            </div>
        </div>
    </div>


    <style>

div.date {
    width: 200px;
}

</style>