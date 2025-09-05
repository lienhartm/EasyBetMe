<?php

class DataControlleur {
    
    public function dataPage() {

        require "view/index.php";

    }

    // Récupération et affichage des matches du jour
    public function dataJson ($path) {

        if (!file_exists($path)) return;
        $myfile = fopen($path, "r");
        $file = fread($myfile, filesize($path));
        fclose($myfile);
        $data = json_decode($file, true);
        if (json_last_error() !== JSON_ERROR_NONE) return;
        return $data;
        
    }

    public function writeJson($path, $file) {

        if(!file_put_contents($path, json_encode($file, JSON_PRETTY_PRINT))) {
            throw new Exception("Erreur lors de l'écriture dans le fichier $filename");
        }
        return;

    }

}

?>
