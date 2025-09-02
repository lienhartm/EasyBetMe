<div class="content">
    <?
        include 'templates/'.$page.'/commun.php';
    ?>

    <div class="main">
        <h2><strong>Crédits</strong></h2>

        <div class="credits">
            <p>Crédits disponibles:</p>
            <p class="credit"><strong><?=$User['credits'];?></strong></p>
            <!--<p><a href="<?=$Url.'/credits';?>">Recharger</a></p>-->
        </div>
    </div>
</div>
