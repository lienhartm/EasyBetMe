<div class="game">
    <?
        $today = date('Y-n-d',time());
        $Jeux = $db->query('SELECT * FROM easybet_games WHERE date >= "'.$today.'" ORDER BY date ASC LIMIT 1');
        $Jeu = $Jeux->fetch();
        
        $c = $Jeu['id_categorie'];
        $Categs = $db->prepare('SELECT * FROM easybet_categorie WHERE id = ?');
        $Categs->execute([$c]);
        $Categ = $Categs->fetch();
        
        $d = $Jeu['id_domicile'];
        $Equipes = $db->prepare('SELECT * FROM easybet_teams WHERE id = ?');
        $Equipes->execute([$d]);
        $dom = $Equipes->fetch();
        
        $v = $Jeu['id_visiteur'];
        $Equipes = $db->prepare('SELECT * FROM easybet_teams WHERE id = ?');
        $Equipes->execute([$v]);
        $vis = $Equipes->fetch();
        
    ?>
    <p class="title"><strong>L'affiche du jour: <?=$Categ['categorie'];?></strong></p>
    <?
        echo '<p onclick="document.location.href=\''.$Url.'/'.$page.'/affiche\'" class="match">';
            echo '<img src="'.$Url.'/images/teams/'.$dom['logo'].'" alt="'.$dom['team'].'" />';
            echo '<strong>'.$dom['team'].'</strong>';
            echo '<strong class="v">'.$vis['team'].'</strong>';
            echo '<img src="'.$Url.'/images/teams/'.$vis['logo'].'" alt="'.$vis['team'].'" />';
        echo '</p>';
    ?>
</div>
