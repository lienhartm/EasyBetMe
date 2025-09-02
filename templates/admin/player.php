<?
$champs = array('date_inscription', 'pseudo', 'email', 'off', 'coins', 'credits', 'points');

$date_inscription = isset($_POST['date_inscription']) ? htmlspecialchars($_POST['date_inscription']) : null;
$pseudo = isset($_POST['pseudo']) ? htmlspecialchars($_POST['pseudo']) : null;
$email = isset($_POST['email']) ? htmlspecialchars($_POST['email']) : null;
$off = isset($_POST['off']) ? intval($_POST['off']) : null;
$coins = isset($_POST['coins']) ? intval($_POST['coins']) : null;
$credits = isset($_POST['credits']) ? intval($_POST['credits']) : null;
$points = isset($_POST['points']) ? intval($_POST['points']) : null;

if ($pseudo) {
    $update = $db->prepare('UPDATE easybet_users SET date_inscription = ?, pseudo = ?, email = ?, off = ?, coins = ?, credits = ?, points = ? WHERE id = ?');
	$update->execute([$date_inscription, $pseudo, $email, $off, $coins, $credits, $points, $niv3]);
    Redirection($Url.'/admin');
}
?>

<div class="players">
    <?
		$Players = $db->prepare('SELECT * FROM easybet_users WHERE id = ?');
		$Players->execute([$niv3]);
		$Player = $Players->fetch();
        ?>
	
	<form method="post">
		<?
			$champs = array('date_inscription', 'pseudo', 'email', 'off', 'coins', 'credits', 'points');
			// $champs = array('id', 'password', 'auth');
			foreach ($Player as $p=>$player) {
				// if (!is_numeric($p) && !in_array($p, $champs)):
				if (in_array($p, $champs)):
				?>
					<p>
						<label for="<?=$p;?>"><?=$p;?></label>
						<input type="text" name="<?=$p;?>" id="<?=$p;?>" placeholder="<?=$p;?>" value="<?=$player;?>" />
					</p>
				<?
				endif;
			}
		?>
		<p><input type="submit" value="OK" /></p>
	</form>
</div>

<style>
div.players {
	grid-column: 1/4;
	overflow: auto;
}
</style>