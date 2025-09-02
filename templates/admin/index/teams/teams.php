<?php

$gifts = $db->prepare('SELECT * FROM easybet_gifts');
$gifts->execute();
$nbGifts = $gifts->rowCount();

?>

<div class="team">
    <p><strong>Cadeaux</strong> <?= $nbGifts ?></p>
    <ul>
        <?php
        // List the gifts
        $Gifts = $db->query('SELECT * FROM easybet_gifts ORDER BY prix');
        while ($Gift = $Gifts->fetch()) {
            // Corrected: Use $Gift instead of $Gifts for the current row
            ?>
                <li>
                    <a href="'.$Url.'/admin/team/'.$Gift['id'].'">

            <?php
            
                    if (strpos($Gift['nom'], '[credit]') !== false) :
            ?>
                        <img src="https://www.easybet.me/images/coin-removebg-preview.png" class="gift" alt="image cadeau">
                                                <?= $Gift['nom'].' - '.$Gift['prix'] ?>
                    </a>
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="gift_id" value="<?=$Gift['id']?>">
                        <!--<button type="submit" name="delete_gift" class="icon">&#xe92b;</button>-->
                        <button type="submit" name="delete_gift">🗑</button>
                    </form>
            <?php else: ?>
                        <img src="<?= $Url ?>/images/gifts/<?= $Gift['img'] ?>" />
                        <?= $Gift['nom'].' - '.$Gift['prix'] ?>
                    </a>
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="gift_id" value="<?=$Gift['id']?>">
                        <button type="submit" name="delete_gift" >🗑</button>
                    </form>
                </li>
            <?php
            endif;
        }
        ?>
    </ul>
</div>

<?php
// Vérifier si le formulaire de suppression a été soumis
if (isset($_POST['delete_gift']) && isset($_POST['gift_id'])) {
    $giftId = $_POST['gift_id'];

    // Préparer la requête pour supprimer le cadeau
    $stmt = $db->prepare('DELETE FROM easybet_gifts WHERE id = :id');
    $stmt->bindParam(':id', $giftId, PDO::PARAM_INT);

    // Exécuter la suppression
    if ($stmt->execute()) {
        
        Redirection ($Url.'/admin');

    } else {
        echo 'Erreur lors de la suppression du cadeau.';
    }
}
?>