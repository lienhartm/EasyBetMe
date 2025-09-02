<div class="gradient"></div>
<main>
	<?php
		if (file_exists('templates/'.$template.'.php')) include 'templates/'.$template.'.php';
		else if ($page=='mentions-legales' || $page=='cgu') include 'templates/'.$page.'.php';
		else include 'templates/404.php';
    ?>
</main>