<?php
echo "<p>Modification d'un cadeau</p>";

$giftId = isset($_GET['niv3']) ? htmlspecialchars($_GET['niv3']) : null;

// S'assurer que l'ID est valide

if ($giftId && is_numeric($giftId)) {
    // Requête pour récupérer le cadeau à modifier
    $stmt = $db->prepare('SELECT * FROM easybet_gifts WHERE id = :id');
    $stmt->bindParam(':id', $giftId, PDO::PARAM_INT);
    $stmt->execute();
    $Gift = $stmt->fetch();

    // Si le cadeau existe, afficher le formulaire de modification
    if ($Gift) {
        echo '<div class="team">';
        echo '<form method="post" enctype="multipart/form-data" action="">';
        echo '<input type="text" name="gift" placeholder="Nom du cadeau" value="'.htmlspecialchars($Gift['nom']).'" required />';
        echo '<input type="number" min="0" max="10000" name="price" id="price" value="'.htmlspecialchars($Gift['prix']).'" placeholder="Prix" required />';
        echo '<label for="logo">Image du cadeau</label>';
        echo '<input type="file" name="img" id="logo" style="display: none;"/>';
        echo '<textarea cols="45" rows="2" name="description" placeholder="Description du cadeau" required>'.htmlspecialchars($Gift['description']).'</textarea>';
        echo '<input type="submit" value="Modifier" />';
        echo '</form>';
        echo '</div>';

        // Traitement du formulaire de modification
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $newGiftName = $_POST['gift'];
            $newPrice = $_POST['price'];
            $newDescription = $_POST['description'];
            $newImage = $_FILES['img'];

            // Gestion de l'image téléchargée
            $imagePath = $Gift['img']; // Par défaut, on garde l'ancienne image
            if ($newImage['error'] === 0) {
                // Assurez-vous que le répertoire pour les images est valide et accessible
                $uploadDir = '/path/to/your/images/directory/'; // Mettez le bon chemin
                $imagePath = $uploadDir . basename($newImage['name']);
                
                // Déplacez l'image téléchargée vers le répertoire de destination
                if (move_uploaded_file($newImage['tmp_name'], $imagePath)) {
                    // Image déplacée avec succès
                } else {
                    echo 'Erreur lors du téléchargement de l\'image.';
                }
            }

            // Mettre à jour les informations du cadeau dans la base de données
            $updateStmt = $db->prepare('UPDATE easybet_gifts SET nom = :nom, prix = :prix, description = :description, img = :img WHERE id = :id');
            $updateStmt->bindParam(':nom', $newGiftName);
            $updateStmt->bindParam(':prix', $newPrice);
            $updateStmt->bindParam(':description', $newDescription);
            $updateStmt->bindParam(':img', $imagePath);
            $updateStmt->bindParam(':id', $giftId, PDO::PARAM_INT);
            
            if ($updateStmt->execute()) {
                // Redirection après la modification
                Redirection($Url.'/admin');
                //header('Location: ' . $Url . '/admin');
                exit();
            } else {
                echo 'Erreur lors de la mise à jour du cadeau.';
            }
        }
    } else {
        echo 'Cadeau non trouvé.';
    }
} else {
    echo 'ID de cadeau invalide ou manquant.';
}

?>
