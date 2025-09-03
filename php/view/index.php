<?php /* temporisation de sortie */ ob_start(); ?>

<?php

$contenu = ob_get_clean();

require_once "template.php";

?>
