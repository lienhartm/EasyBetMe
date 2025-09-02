<? header("X-Robots-Tag: noindex, nofollow", true); ?>
<div class="legal">
<?php
$id = 27;
$Clients = $db->query('SELECT * FROM clients WHERE id = "'.$id.'"');
$Client = $Clients->fetch();

$ml = array(
	'Raison sociale' => 'MonWebPro.com',
	'Directeur de publication' => 'Jean-Charles Oberlé',
	'Forme juridique' => 'Affaire personnelle',
	'Siège social' => '8 route de Colmar - 68320 GRUSSENHEIM',
	'Capital' => ($Client['capital']>0) ? $Client['capital'] : null,
	'RCS' => $Client['rcs'],
	'Numéro d\'identification de TVA' => $Client['num_tva'],
	'Contact' => 'contact@monwebpro.com',
	'SIREN' => $Client['siren'],
	'SIRET' => $Client['siret'],
	'Code APE' => $Client['code_ape']
);

$Credits = '<p>Les images de fond proviennent du site <a href="https://www.pixabay.com" target="_blank">Pixabay</a>.</p>';

include '../../tools/mentions-legales.php';
?>
</div>

<script>
$(document).prop('title', 'Mentions légales - <?php echo $Site['nom']; ?>');
</script>