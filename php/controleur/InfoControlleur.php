<?php

require_once "controleur/DataControlleur.php";

class InfoControlleur {
    
    public function infoPage($competition = null) {

        if ($competition != null) {

            $ctrl = new DataControlleur();

            $competitions = $ctrl->dataJson("/var/www/html/data/competition-info-".$competition.".json");

            $matches = $ctrl->dataJson("/var/www/html/data/competition-matches-".$competition."-".date("Y").".json");

            $standings = $ctrl->dataJson("/var/www/html/data/competition-standings-".$competition."-".date("Y").".json");

            $scorers = $ctrl->dataJson("/var/www/html/data/competition-scorers-".$competition."-".date("Y").".json");

            require "view/info/competition.php";

        }

        $ctrl = new DataControlleur();
        $data = $ctrl->dataJson("/var/www/html/data/competitions.json");

        require "view/info/info.php";

    }
}

?>
