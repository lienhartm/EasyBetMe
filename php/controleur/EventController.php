<?php

class EventControlleur {
    
    public function eventPage() {

        require "view/index.php";

    }

    // Méthode pour rechercher un événement qui commence dans les 7 jours
    public function searchEvent() {

        $nowStr = $currentDate->format('Y-m-d');
        $futureStr = $sevenDaysLater->format('Y-m-d');

        // Chercher un événement qui commence dans les 7 jours
        $Event = $db->prepare('
            SELECT * FROM easybet_events WHERE datedebut >= :now AND datedebut <= :future
            ORDER BY datedebut ASC
            LIMIT 1
        ');
        $Event->execute([
            'now' => $nowStr,
            'future' => $futureStr
        ]);

        return $Event->fetchAll(PDO::FETCH_ASSOC);

        require "view/index.php";

    }

    // Méthode pour récupérer l'événement actuel
    public function actualEvent() {

        // Récupérer l'événement actuel
        $currentEvent = $db->query('SELECT * FROM easybet_events');
        return $currentEvent->fetch(PDO::FETCH_ASSOC);

        require "view/index.php";
    }
}

?>
