<?php

$Events = $db->prepare('SELECT * FROM easybet_events');
$Events->execute();
$nbEvents = $Events->rowCount();

?>

<div class="game">
    <p><strong>Compétitions</strong> <?= $nbEvents ?></p>
    <p><b>Date de début - date de fin - Nom de compétition - Cadeau</b></p>
    <ul>
        <?php
            // Récupérer les événements
            $Events = $db->query('SELECT * FROM easybet_events');
            while ($Event = $Events->fetch()) {
                echo '
                    <li>
                        <a href="'.$Url.'/admin/game/'.$Event['id'].'">
                            <i>Date début: '.$Event['datedebut'].' - date fin: '.$Event['datefin'].'</i>
                            &nbsp;&nbsp;&nbsp;&nbsp;Compétition: '.$Event['competition'].'
                        </a>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="event_id" value="'.$Event['id'].'">
                            <button type="submit" name="delete_event" >🗑</button>
                        </form>
                    </li>
                ';
            }
        ?>
    </ul>
</div>

<?php
// Vérifier si le formulaire de suppression a été soumis
if(isset($_POST['delete_event']) && isset($_POST['event_id'])) {
    $eventId = $_POST['event_id'];

    // Préparer la requête pour supprimer l'évènement
    $stmt = $db->prepare('DELETE FROM easybet_events WHERE id = :id'); // Corrigé pour supprimer de easybet_events
    $stmt->bindParam(':id', $eventId, PDO::PARAM_INT);

    // Exécuter la suppression
    if ($stmt->execute()) {
        Redirection ($Url.'/admin');
    } else {
        echo 'Erreur lors de la suppression de l\'vénement.';
    }
}
?>

<style>
    li {
        height: 25px;
    }
    pre {
        height: 25px;
    }
</style>
