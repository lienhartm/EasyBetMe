<?php
// Enregistrement de la mise
$g = isset($_POST['gift']) ? intval($_POST['gift']) : null;
$mise = isset($_POST['mise']) ? intval($_POST['mise']) : null;

if ($mise) {
    // Eviter la triche en  permettant de miser plus que le solde disponible
    if ($mise <= $User['coins']) {
        // On regarde si le joueur a déjà misé sur ce cadeau. 
        $checkUsers = $db->prepare('SELECT * FROM easybet_gifts_users WHERE id_users=? AND id_gifts=?');
        $checkUsers->execute([$User['id'], $g]);
        $nbResp = $checkUsers->rowCount();

        if ($nbResp==0) {
            // Si il n'a pas encore misé in fait un insert
            $insert=$db->prepare('INSERT INTO easybet_gifts_users (id, id_users, id_gifts, coins) VALUES ("",?,?,?)');
            $insert->execute([$User['id'], $g, $mise]);
        }
        else {
            // sinon on update
            $update=$db->prepare('UPDATE easybet_gifts_users SET coins=coins+'.$mise.' WHERE id_users=? AND id_gifts=?');
            $update->execute([$User['id'], $g]);
        }

        // On enlève les coins misés par l'user
        $pay = $db->prepare('UPDATE easybet_users SET coins=coins-'.$mise.' WHERE id=?');
        $pay->execute([$User['id']]);

        // On recharge la page
        Redirection($Url.'/gift');
    }
}
?>

<div style="margin:auto;text-align:center;">
<h2 class='title'><strong>Tentez de remporter un ou plusieurs cadeaux sur easyBet</strong></h2>
<h3 class='desc'>Misez vos tickets de tombolat (Coins) pour participer au tirage au sort, dès que le cadeau sera débloqué...</h3>
</div>

<div class="wrapper">
    <div class="container">
        <?php
            // List the gifts
            $Gifts = $db->query('SELECT * FROM easybet_gifts WHERE off=0');

            // Vérification du nombre de cadeaux
            if ($Gifts->rowCount() == 0):
                ?><h3>Désolé, aucun cadeau disponible !</h3><?
            else:


                // Boucle sur les cadeaux disponibles
                while ($Gift = $Gifts->fetch()):
                    $giftId = $Gift['id'];
                    $userId = $User['id'];
                    if (strpos($Gift['nom'], '[credit]') !== false) :
                        $nom = str_replace('[credit]', '', $Gift['nom']);

                    ?>
                    <div>
                        <p><img src="https://www.easybet.me/images/coin-removebg-preview.png" class="gift" alt="image cadeau"></p>
                        <p class="desc"><?=$Gift['description'];?></p>

                        <p class="sub">Votre mise</p>
                        <?
                        $Coins = $db->prepare('SELECT coins FROM easybet_gifts_users WHERE id_users=? AND id_gifts=?');
                        $Coins->execute([$userId, $giftId]);
                        $Coin = $Coins->fetch();
                        $nbCoins = $Coins->rowCount();
                        ?>
                        <p class="mise"><?=($nbCoins>0) ? '<span class="mise">'.$Coin['coins'].'</p>' : 'Vous n\'avez pas encore misé sur ce lot'; ?></p>

                        <form method="POST">
                            <input type="hidden" name="gift" value="<?=$Gift['id'];?>" />  
                            <input type="number" min="1" max="<?=$User['coins'];?>" name="mise" value="<?=$User['coins'];?>" />  
                            <input type="submit" value="Miser" />  
                        </form>

                        <p class="sub">Débloquage du cadeau</p>
                        <?
                        $total = $db->prepare('SELECT SUM(coins) FROM easybet_gifts_users WHERE id_users=? AND id_gifts=?');
                        $total->execute([$User['id'], $giftId]);
                        $sum = $total->fetch();
                        $s = ($sum[0] / $Gift['prix'])*100;
                        ?>
                        <div class="total">
                            <div class="unblock" style="width: <?=$s;?>%;"></div>
                        </div>
                        <?php
                            if ($s == 100) :
                        ?>
                                <form method="POST" style="display:inline;">
                                    <input type="hidden" name="gift_id" value="<?= $Gift['id'] ?>">
                                    <button type="submit" name="buy_gift" class="icon">Buy</button>
                                </form>
                        <?php
                            endif;
                        ?>
                        </div>
                    <?php
                    else:
                    ?>
                    <div>
                        <p class="title"><strong><?=ucfirst($Gift['nom']);?></strong></p>
                        <p><img src="<?=$Url.'/images/gifts/'.$Gift['img'];?>" class="gift" alt="image cadeau"></p>
                        <p class="desc"><?=$Gift['description'];?></p>
                        <p class="partner"><a href="<?=$Gift['link'];?>" target="_blank"><?=$Gift['partner'];?></a></p>

                        <p class="sub">Votre mise</p>
                        <?
                        $Coins = $db->prepare('SELECT coins FROM easybet_gifts_users WHERE id_users=? AND id_gifts=?');
                        $Coins->execute([$userId, $giftId]);
                        $Coin = $Coins->fetch();
                        $nbCoins = $Coins->rowCount();
                        ?>
                        <p class="mise"><?=($nbCoins>0) ? '<span class="mise">'.$Coin['coins'].'</p>' : 'Vous n\'avez pas encore misé sur ce lot'; ?></p>

                        <form method="POST">
                            <input type="hidden" name="gift" value="<?=$Gift['id'];?>" />  
                            <input type="number" min="1" max="<?=$User['coins'];?>" name="mise" value="<?=$User['coins'];?>" />  
                            <input type="submit" value="Miser" />  
                        </form>

                        <p class="sub">Débloquage du cadeau</p>
                        <?
                        $total = $db->prepare('SELECT SUM(coins) FROM easybet_gifts_users WHERE id_users=? AND id_gifts=?');
                        $total->execute([$User['id'], $giftId]);
                        $sum = $total->fetch();
                        $s = ($sum[0] / $Gift['prix'])*100;
                        ?>
                        <div class="total">
                            <div class="unblock" style="width: <?=$s;?>%;"></div>
                        </div>
                        <?php
                            if ($s == 100) :
                        ?>
                                <form method="POST" style="display:inline;">
                                    <input type="hidden" name="gift_id" value="<?= $Gift['id'] ?>">
                                    <button type="submit" name="buy_gift" class="icon">Buy</button>
                                </form>
                        <?php
                            endif;
                        ?>
                    </div>
                    <?
                    endif;
                endwhile;
            endif;
        ?>
    </div>
</div>

<?php
// Vérifier si le formulaire de suppression a été soumis
if (isset($_POST['buy_gift']) && isset($_POST['gift_id'])) {
    $giftId = $_POST['gift_id'];

    // Fetch the gift details
    $GiftQuery = $db->prepare('SELECT * FROM easybet_gifts WHERE id = :id');
    $GiftQuery->bindParam(':id', $giftId, PDO::PARAM_INT);
    $GiftQuery->execute();
    $Gift = $GiftQuery->fetch(); // Fetch the gift data
    
    // Get the user data (Assuming session has the user's id)
    // Fetch user data

    $Coins = $db->prepare('SELECT coins FROM easybet_gifts_users WHERE id_users=? AND id_gifts=?');
    $Coins->execute([$userId, $giftId]);
    $Coin = $Coins->fetch();
    
    // Clé secrète (doit être secrète et partagée entre l'émetteur et le récepteur)
    $secretKey = "st"; 

    // Générer un iv (vecteur d'initialisation) aléatoire de 16 octets
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));

    // Chiffrement AES-256-CBC
    $encryptedDataUserId = openssl_encrypt($userId, 'aes-256-cbc', $secretKey, 0, $iv);
    $encryptedDataGiftId = openssl_encrypt($giftId, 'aes-256-cbc', $secretKey, 0, $iv);

    // Encodez les données en base64 pour les rendre sécurisées pour l'URL
    $encryptedDataUrlUserId = base64_encode($encryptedDataUserId . '::' . $iv);
    $encryptedDataUrlGiftId = base64_encode($encryptedDataGiftId . '::' . $iv);

    // Construire l'URL avec les données chiffrées
    //echo "URL avec données chiffrées : ";
    //echo "https://example.com?data=" . urlencode($encryptedDataUrl);

    if (intval($Coin['coins']) === intval($Gift['prix'])) {

        if (strpos($Gift['nom'], '[credit]') !== false) {

                // Préparer et exécuter la requête en sécurité
        try {
            $update = $db->prepare('UPDATE easybet_users SET credits = credits + :score WHERE id = :userId');
            $update->execute([
                ':score' => floor($Gift['prix'] / 10),
                ':userId' => $User['id'],
            ]);
        }
        catch (PDOException $e) {
        }

        try {
            // Préparer la requête pour supprimer le cadeau
            $stmt = $db->prepare('DELETE FROM easybet_gifts WHERE id = :id');
            $stmt->bindParam(':id', $giftId, PDO::PARAM_INT);
            $stmt->execute();
        } catch (PDOException $e) {
            // Gérer l'erreur si nécessaire
        }

        Redirection($Url."/gift");

        }

        Redirection($Url.'/gift/purchase?iU='.urlencode($encryptedDataUrlUserId).'&iG='.urlencode($encryptedDataUrlGiftId));
    } else {
        Redirection($Url.'/gift/sorry');
    }
    
}
?>





<style>
    .wrapper {
        display: flex;
        justify-content: center;
        margin: 50px;
    }

    .container {
        display: grid;
        gap: 50px;
        grid-template-columns: auto auto auto;
        padding: 10px;
        margin: auto;
        max-width: 800px;
        justify-content: center;
    }

    .container > div {
        background-color: #f1f1f1;
        border: 1px solid black;
        padding: 20px;
        font-size: 12px;
        text-align: center;
        width: auto;
        height: auto;
    }

    img {
        height: 100px;
    }

    h3 {
        font-weight: bold;
    }

    @media only screen and (max-width: 600px) {
        div.container {
            display: flex;
            flex-direction: column;
        }
    }
</style>
