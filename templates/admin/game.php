<?php
echo "<p>Modification d'un événement</p>";

$eventId = isset($_GET['niv3']) ? htmlspecialchars($_GET['niv3']) : null;

// S'assurer que l'ID est valide

if ($eventId && is_numeric($eventId)) {
    // Requête pour récupérer le cadeau à modifier
    $stmt = $db->prepare('SELECT * FROM easybet_events WHERE id = :id');
    $stmt->bindParam(':id', $eventId, PDO::PARAM_INT);
    $stmt->execute();
    $Event = $stmt->fetch();

    // Si le cadeau existe, afficher le formulaire de modification
    if ($Event) {
        echo '<div class="game">';
        echo '<form method="post" enctype="multipart/form-data">';
        echo '<input type="date" name="date_debut" placeholder="Date de début" value="'.htmlspecialchars($Event['datedebut']).'" required />'; //<!-- date debut -->
        echo '<input type="date" name="date_fin" placeholder="Date de fin" value="'.htmlspecialchars($Event['datefin']).'" required />'; //<!-- date fin -->
        echo '<input type="text" name="competition" placeholder="Titre événement" value="'.htmlspecialchars($Event['competition']).'" required />';
        echo '<input type="text" name="cadeau" placeholder="Ligne avant l\'image evenement" value="'.htmlspecialchars($Event['cadeau']).'" required />';
        echo '<label for="logo">Image evenement</label>';
        echo '<input type="file" name="png" id="logo" required style="display: none;"/>';
        echo '<textarea cols="54" rows="2" name="description" placeholder="Description de l\'événement" required>'.htmlspecialchars($Event['description']).'</textarea>';
        echo '<input type="submit" value="OK" />';
        echo '</form>';
        echo '</div>';

        // Traitement du formulaire de modification
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $newEventDatedebut = $_POST['datedebut'];
            $newEventDatefin = $_POST['datefin'];
            $newEventCompetition = $_POST['competition'];
            $newEventCadeau = $_POST['cadeau'];
            $newEventImage = $_FILES['png'];
            $newEventDescription = $_POST['description'];

            // Gestion de l'image téléchargée
            $imagePath = $Event['png']; // Par défaut, on garde l'ancienne image
            if ($newImage['error'] === 0) {
                $uploadDir = './images/events/';
                $imagePath = $uploadDir . basename($newEventImage['name']);
                
                // Déplacez l'image téléchargée vers le répertoire de destination
                if (move_uploaded_file($newEventImage['tmp_name'], $imagePath)) {
                    // Image déplacée avec succès
                } else {
                    echo 'Erreur lors du téléchargement de l\'image.';
                }
            }

            // easybet_events (id, datedebut, datefin, competition, cadeau, description, img)
            // Mettre à jour les informations du cadeau dans la base de données
            $updateStmt = $db->prepare('UPDATE easybet_events SET datedebut = :datedebut, datefin = :datefin, competition = :competition, cadeau = :cadeau, png = :png, description = :description WHERE id = :id');
            $updateStmt->bindParam(':datedebut', $newEventDatedebut);
            $updateStmt->bindParam(':datefin', $newEventDatefin);
            $updateStmt->bindParam(':competition', $newEventCompetition);
            $updateStmt->bindParam(':cadeau', $newEventCadeau);
            $updateStmt->bindParam(':png', $imagePath);
            $updateStmt->bindParam(':description', $newEventDescription);
            $updateStmt->bindParam(':id', $eventId, PDO::PARAM_INT);
            
            if ($updateStmt->execute()) {
                // Redirection après la modification
                Redirection($Url.'/admin');
                exit();
            } else {
                echo 'Erreur lors de la mise à jour de l\'événement.';
            }
        }
    } else {
        echo 'Evénement non trouvé.';
    }
} else {
    echo 'ID de l\'événement invalide ou manquant.';
}

?>
