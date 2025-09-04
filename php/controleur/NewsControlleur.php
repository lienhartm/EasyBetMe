<?php

class NewsControlleur {
    
    public function newsPage() {

        require_once "controleur/DataControlleur.php";

        $ctrl = new DataControlleur();
        $data = $ctrl->dataJson("/var/www/html/data/footnews.json");


        require "view/news/news.php";

    }
}

?>
