<?php

class HomeControlleur {
    
    public function homePage() {


        require_once "controleur/DataControlleur.php";

        $ctrl = new DataControlleur();
        $data = $ctrl->dataJson("/var/www/html/data/matches-" . date('Y-m-d', time()) . ".json");

        require "view/home/home.php";

    }

    public function aidePage() {

        require "view/aide/aide.php";

    }
}

?>
