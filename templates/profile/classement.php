<div class="content">
    <?
        include 'templates/'.$page.'/commun.php';
    ?>

    <div class="main classement">
        <h2><strong>Classement</strong></h2>

        <div class="datas">
            <div class="head">
                <div class="order">#</div>
                <div class="pseudo">Joueur</div>
                <div class="score">Points</div>
            </div>
            <?
                $j = 1;
                $Joueurs = $db->prepare('SELECT * FROM easybet_users WHERE off=0 ORDER BY points DESC');
                $Joueurs->execute();
                while ($Joueur = $Joueurs->fetch()):
                    ?>
                        <div class="body <?=($Joueur['id']==$User['id']) ? 'me' : null;?>">
                            <div class="order"><?=$j;?></div>
                            <div class="pseudo"><strong><?=$Joueur['pseudo'];?></strong></div>
                            <div class="score"><?=$Joueur['points'];?></div>
                        </div>
                    <?
                    $j++;
                endwhile;
            ?>
        </div>
    </div>
</div>
