<?php

require_once "controleur/DataControlleur.php";

class InfoControlleur {
    
    public function infoPage($competition = null) {

        if ($competition != null) {

            $ctrl = new DataControlleur();

            $competitions = $ctrl->dataJson("/var/www/html/data/info-".$competition.".json");

            $matches = $ctrl->dataJson("/var/www/html/data/matches-".$competition.".json");

            $standings = $ctrl->dataJson("/var/www/html/data/standings-".$competition.".json");

            $scorers = $ctrl->dataJson("/var/www/html/data/scorers-".$competition.".json");

            require "view/info/competition.php";

        }

        $ctrl = new DataControlleur();
        $data = $ctrl->dataJson("/var/www/html/data/competitions.json");

        require "view/info/info.php";

    }
}

?>
