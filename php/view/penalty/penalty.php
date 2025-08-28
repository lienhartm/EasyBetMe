<?php

// temporisation de sortie
ob_start();

$contenu = ob_get_clean();

require_once "template.php";

?>
