<?php

// temporisation de sortie
ob_start();

$contenu = ob_get_clean();

require "view/template.php";

?>
