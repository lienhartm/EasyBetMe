<link href="../styles/_infos.css" rel="stylesheet" type="text/css" />
<?php

// temporisation de sortie
    ob_start();

    if(isset($data['competitions'])) { $data = $data['competitions']; } else { echo "Aucune donnée de ligue ou coupe disponible."; }

?>

<div class="competitions">
    <h3>Des informations sur les ligues et les coupes qui t'intéressent !</h3>
    <br />
    <div class="grid-container">
        <?php
            foreach($data as $competition) {
                //echo "<a href='".$Url."/informations/info/".$competition['code']."' >
                echo "<a href='index.php?action=infos&competition=".$competition["code"]."' >
                        <div class='competition'>
                            <figure>
                                <img class='emblem' src='".$competition['emblem']."' alt='competition flag' />
                                <figcaption>
                                    <p class='name'>".$competition['name']."</p>
                                    <p class='areaname'><img class='flag' src='".$competition['area']['flag']."' alt='logo area' width='20px' height='20px' />".$competition['area']['name']."</p>
                                </figcaption>
                            </figure>
                        </div>
                    </a>";       
            }
        ?>
    </div>
</div>

<?php

    $contenu = ob_get_clean();

    require_once "template.php";

?>
