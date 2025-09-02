<div class="points">

    <? $link = $Url.'/'.$page.'/credits'; ?>
    <div class="bloc" id="credits" onclick="document.location.href='<?=$link;?>';">
        <p class="head">Crédits:</p>
        <p class="icon">&#xe93b;</p>
        <p class="main"><a href="<?=$link;?>"><strong><?=$User['credits'];?></strong></a></p>
    </div>
        
    <? $link = $Url.'/'.$page.'/points'; ?>
    <div class="bloc" id="points" onclick="document.location.href='<?=$link;?>';">
        <p class="head">Points:</p>
        <p class="icon">&#xe99e;</p>
        <p class="main"><a href="<?=$link;?>"><strong><?=$User['points'];?></strong></a></p>
    </div>

    <? $link = $Url.'/'.$page.'/coins'; ?>
    <div class="bloc" id="coins" onclick="document.location.href='<?=$link;?>';">
        <p class="head">Coins:</p>
        <p class="icon">&#xe939;</p>
        <p class="main"><a href="<?=$link;?>"><strong><?=$User['coins'];?></strong></a></p>
    </div>

    <? $link = $Url.'/'.$page.'/classement'; ?>
    <div class="bloc" id="position" onclick="document.location.href='<?=$link;?>';">
        <? 
            if ($User['points']>0):

            $Players = $db->prepare('SELECT * FROM easybet_users WHERE off = 0 ORDER BY points DESC');
            $Players->execute();
            $nbPlayers = $Players->rowCount();

            $p = 1;
            while ($Player = $Players->fetch()) {
                if ($Player['id']==$User['id']) {
                    $pos = $p;
                }
                $p++;
            }
            $position = ($pos==1) ? $pos.'<sup>er</sup>' : $pos.'<sup>e</sup>';
        ?>
        <p class="head">Classement:</p>
        <p class="icon">&#xe9d9;</p>
        <p class="main"><a href="<?=$link;?>"><strong><?=$position;?>/<?=$nbPlayers;?></strong></a></p>
        <? else: ?>
        <p class="head">Classement:</p>
        <!--<p class="icon">&#xe9d9;</p>-->
        <p class="main2"><a href="<?=$link;?>">Vous n'avez pas encore marqué de point pour vous classer</a></p>
        <? endif; ?>
    </div>

    <? $link = $Url.'/'.$page.'/cadeaux'; ?>
    <div class="bloc" id="cadeaux" onclick="document.location.href='<?=$link;?>';">
        <? 
            $Pronos = $db->prepare('SELECT * FROM easybet_bets WHERE id_user=?');
            $Pronos->execute([$User['id']]);
            $nbPronos = $Pronos->rowCount();
            ?>
        <p class="head">Evénement</p>
        <p class="icon"><i class='fa'>&#xf073;</i></p>
        <p class="main"><a href="<?=$link;?>"><strong>Voir</strong></a></p>
    </div>
    
    <? $link = $Url.'/'.$page.'/settings'; ?>
    <div class="bloc" id="pronos" onclick="document.location.href='<?=$link;?>';">
        <? 
            $Pronos = $db->prepare('SELECT * FROM easybet_bets WHERE id_user=?');
            $Pronos->execute([$User['id']]);
            $nbPronos = $Pronos->rowCount();
        ?>
        <p class="head">Préférences:</p>
        <p class="icon">&#xe971;</p>
        <p class="main"><a href="<?=$link;?>"><strong>Modifier</strong></a></p>
    </div>

    <? $link = $Url.'/logout'; ?>
    <div class="bloc logout" id="profile" onclick="document.location.href='<?=$link;?>';">
        <p class="head">Déconnexion</p>
        <p class="icon">&#xe9b6;</p>
        <p class="main"><a href="<?=$link;?>"><strong>Logout</strong></a></p>
    </div>
</div>