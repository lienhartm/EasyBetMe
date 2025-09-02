<div id="cadeau">
    <div class="cadeau">
        <? 
        $img = $Url.'/images/euro2024.svg';
        $park = $Url.'/images/europapark.svg';
        ?>

        <h2><strong>Du 14 juin au 14 juillet: Spécial Euro 2024</strong></h2>

        <div class="images">
            <img src="<?=$img;?>" class="logo">
            <img src="<?=$park;?>" class="logo">
        </div>

        

        <ol>
            <li>Faites votre pronostic quotidien sur <a href="<?=$Url;?>">easyBet.me</a>,</li>
            <li>Hissez vous à la première place,</li>
            <li>Remportez <strong>4 places pour Europapark</strong> !</li>
        </ol>

        <div class="partenaires">
            <?
                $Partners = array(
                    'https://www.2r-applications.com/'=>$Url.'/images/partners/2rapplications.svg', 
                    'https://www.badtunnabykr.com/'=>'https://www.badtunnabykr.com/images/BadTunna-Logo.png',
                    'https://www.alsaceadministratif.com/'=>'https://www.alsaceadministratif.com/images/alsace-administratif-logo.png', 
                    'https://www.create.alsace/'=>'https://www.create.alsace/images/Logo-Create-2023.png',
                    'https://www.hetlapizz.fr/'=>'https://www.hetlapizz.fr/images/hetlapizz-logo.png', 
                    'https://www.savbruno.fr/'=>'https://www.savbruno.fr/images/logo-sav-bruno.png', 
                    'https://www.restaurant-melichkann.fr/'=>'https://www.restaurant-melichkann.fr/images/melichkann.png', 
                    'https://www.monwebpro.com/'=>'https://www.monwebpro.com/images/monwebpro-logo.png'
                );

                foreach ($Partners as $purl=>$pimg):
                    ?>
                        <a href="<?=$purl;?>" target="_blank">
                            <img src="<?=$pimg;?>">
                        </a>
                    <?
                endforeach;
            ?>
        </div>
    </div>
</div>