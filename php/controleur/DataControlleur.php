<?php

class DataControlleur {
    
    public function dataPage() {

        require "view/index.php";

    }

    // Récupération et affichage des matches du jour
    public function dataMatches () {

        $path = "/var/www/html/data/matches-" . date('Y-m-d', time()) . ".json";
        $myfile = fopen($path, "r") or die("Impossible d'ouvrir le fichier !");
        $file = fread($myfile, filesize($path));
        fclose($myfile);
        $data = json_decode($file, true);
        if (json_last_error() !== JSON_ERROR_NONE) die('Erreur lors du décodage du JSON : ' . json_last_error_msg());
        return $data['matches'];
        
    }

    public function dataCompetitions() {

        $path = "/var/www/html/data/competitions.json";
        $myfile = fopen($path, "r") or die("Impossible d'ouvrir le fichier !");
        $file = fread($myfile, filesize($path));
        fclose($myfile);
        $data = json_decode($file, true);
        if (json_last_error() !== JSON_ERROR_NONE) die('Erreur lors du décodage du JSON : ' . json_last_error_msg());
        return $data['competitions'];

    }
}

?>
