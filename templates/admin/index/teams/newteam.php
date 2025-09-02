<?php
$gift = isset($_POST['gift']) ? htmlspecialchars($_POST['gift']) : null;
$checked = isset($_POST['credit']) ? '[credit]' : '1'; // Check if the credit checkbox is checked
$price = isset($_POST['price']) ? htmlspecialchars($_POST['price']) : null;
$partner = isset($_POST['partner']) ? htmlspecialchars($_POST('partner')) : null;
$link = isset($_POST['link']) ? htmlspecialchars($_POST['link']) : null;
$description = isset($_POST['description']) ? htmlspecialchars($_POST['description']) : null;
$file = null;



if ($checked == '[credit]' && isset($price)) {
    // If credit is checked, set the price to 10% of the original price
    $description = "Bon de crédits de " . floor($price / 10) . " points";
    $file = "";
    $partner = "";
    $link = "";

    $insert = $db->prepare('INSERT INTO easybet_gifts (nom, description, prix, img, partner, link) VALUES (?, ?, ?, ?, ?, ?)');
    if ($insert->execute([$checked, $description, $price, $file, $partner, $link])) {
        echo "Added successfully!";
    } else {
        echo "Error adding gift.";
    }

}
// Insert data into the database
else if ($gift && $price && $description && $file && $partner && $link) {

    // Handle file upload
    if (isset($_FILES['img']) && $_FILES['img']['error'] == UPLOAD_ERR_OK) {
        // Vérification du type de fichier
        $fileType = pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION);
        if (!in_array($fileType, ['jpg', 'jpeg', 'png', 'gif'])) {
            echo "Only image files (jpg, jpeg, png, gif) are allowed.";
        }

        if (is_uploaded_file($_FILES['img']['tmp_name'])) {
            $file = $_FILES['img']['name'];
            $uploadDir = './images/gifts/';
            $uploadPath = $uploadDir . basename($file);
            
            // Check if the directory exists, otherwise create it
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            // Move the uploaded file
            if (move_uploaded_file($_FILES['img']['tmp_name'], $uploadPath)) {
                echo "File successfully uploaded!";
            } else {
                echo "Error uploading file.";
            }
        }
    }

    $insert = $db->prepare('INSERT INTO easybet_gifts (nom, description, prix, img, partner, link) VALUES (?, ?, ?, ?, ?, ?)');
    if ($insert->execute([$checked, $description, $price, $file, $partner, $link])) {
        echo "Added successfully!";
    } else {
        echo "Error adding gift.";
    }
}


?>

<div class="team">
    <form method="post" enctype="multipart/form-data">
        <label for="credit"><input type="checkbox" name="credit" id="credit" />Crédit (cochez la case pour un bon de [10% de la somme] crédits )</label>
        <input type="text" name="gift" placeholder="Ajouter un cadeau" required />
        <input type="number" min="0" max="10000" name="price" id="price" placeholder="Price" required />
        <div style="width:100%;">
            <input type="text" name="partner" placeholder="partner" />
            <input type="email" name="link" placeholder="lien de l'offre" />
        </div>
        <label for="img">Cadeau</label>
        <input type="file" name="img" id="img" required hidden/>
        <textarea cols="45" rows="2" name="description" placeholder="Description du cadeau" required></textarea>
        <input type="submit" value="OK" />
    </form>
</div>


<script>

document.getElementById('credit').addEventListener('change', function () {
    const isChecked = this.checked;

    const priceInput = document.getElementById('price');
    priceInput.step = 10;

    // Cibles des éléments à cacher/désactiver
    const elements = [
        document.querySelector('input[name="gift"]'),
        document.getElementById('img'),
        document.querySelector('textarea[name="description"]'),
        document.querySelector('label[for="img"]'),
        document.querySelector('input[name="partner'),
        document.querySelector('input[name=link]')
    ];

    elements.forEach(el => {
        if (isChecked) {
            el.disabled = true;
            el.style.display = 'none';
        } else {
            el.disabled = false;
            el.style.display = ''; // remet à la normale
        }
    });
});

</script>
