<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $datedebut = isset($_POST['date_debut']) ? htmlspecialchars($_POST['date_debut']) : null;
    $datefin = isset($_POST['date_fin']) ? htmlspecialchars($_POST['date_fin']) : null;
    $competition = isset($_POST['competition']) ? htmlspecialchars($_POST['competition']) : null;
    $cadeau = isset($_POST['gift']) ? htmlspecialchars($_POST['gift']) : null;
    $description = isset($_POST['description']) ? htmlspecialchars($_POST['description']) : null;
    $file = null;

    // Vérifier la disponibilité des événements à la date spécifiée
    $Event = $db->prepare('SELECT * FROM `easybet_events` WHERE (datedebut <= :datedebut AND datefin >= :datedebut) OR (datedebut <= :datefin AND datefin >= :datefin)');
    $Event->bindParam(':datedebut', $datedebut);
    $Event->bindParam(':datefin', $datefin);
    $Event->execute();
    
    if ($Event->rowCount() === 0) {
        // Gérer le téléchargement de fichiers
        if (isset($_FILES['logo']) && $_FILES['logo']['error'] == UPLOAD_ERR_OK) {
            $file = $_FILES['logo']['name'];
            $uploadDir = './images/events/';
            $uploadPath = $uploadDir . basename($file);
            
            // Vérifier si le répertoire existe, sinon le créer
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            // Vérifier le type et la taille du fichier
            $fileType = pathinfo($uploadPath, PATHINFO_EXTENSION);
            if (!in_array($fileType, ['png', 'jpg', 'jpeg', 'gif'])) {
                echo "Only PNG, JPG, and GIF files are allowed.";
            }

            // Déplacer le fichier téléchargé
            if (move_uploaded_file($_FILES['logo']['tmp_name'], $uploadPath)) {
                echo "File successfully uploaded!";
            } else {
                echo "Error uploading file.";
            }
        } else {
            echo "File not uploaded.";
        }

        // Insérer les données dans la base de données
        if ($datedebut && $datefin && $competition && $cadeau && $description && $file) {
            $insert = $db->prepare('INSERT INTO easybet_events (datedebut, datefin, competition, cadeau, description, img) VALUES (?, ?, ?, ?, ?, ?)');
            if ($insert->execute([$datedebut, $datefin, $competition, $cadeau, $description, $file])) {
                echo "Event added successfully!";
            } else {
                echo "Error adding event to the database.";
            }
        } else {
            echo "Please fill all fields and upload a logo.";
        }
    } else {
        echo "Erreur ! Une autre programmation est déjà comptée à cette date !";
    }
}
?>

<div class="game">
    <form method="post" enctype="multipart/form-data">
        <input type="date" name="date_debut" placeholder="Date de début" required />
        <input type="date" name="date_fin" placeholder="Date de fin" required />
        <input type="text" name="competition" placeholder="Titre de l'événement" required />
        <input type="text" name="gift" placeholder="Ligne avant l'image de l'événement" required />
        <label for="logo">Image de l'événement</label>
        <input type="file" name="logo" id="logo" required hidden/>
        <textarea cols="54" rows="2" name="description" placeholder="Description de l'événement" required></textarea>
        <input type="submit" value="OK" />
    </form>
</div>
