<div class="content">
    <?
        include 'templates/'.$page.'/commun.php';
        $img = $Url.'/images/euro2024.svg';
    ?>

    <div class="main">
        <h2><strong>Du 14 juin au 14 juillet: Spécial Euro 2024</strong></h2>

        
        <div class="cadeau">
            <div class="images">
                <img src="<?=$img;?>" class="logo" style="display: block; margin: 0 auto; width: auto; height: 200px;">
            </div>

            <p>Du 14 juin au 14 juillet 2024</p>

            <div class="podium">
                <div class="marche">
                    <span>2<sup>e</sup></span>
                    <strong>30 crédits</strong>
                </div>
                <div class="marche">
                    <span>1<sup>er</sup></span>
                    <strong>50 crédits</strong>
                </div>
                <div class="marche">
                    <span>3<sup>e</sup></span>
                    <strong>10 crédits</strong>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    div.podium {
        width: 600px;
        height: 200px;
        margin: 0 auto;
    }
    div.marche {
        width: 200px;
        display: flex;
        align-items: center;
        justify-content: center;
        float: left;
        border: solid 1px #333;
        vertical-align: bottom;
        flex-direction: column;
        font-size: 1.5em;
    }
    div.marche:nth-child(1) { height: 120px; margin-top: 80px; background: #005; color: #fff; }
    div.marche:nth-child(2) { height: 200px; }
    div.marche:nth-child(3) { height: 80px; margin-top: 120px; background: #500; color: #fff; }

    div.marche span {
        display: block;
    }
    div.marche strong {
        display: block;
    }
</style>
