<?
if ($_SESSION['login']!=1) {
	Redirection($Url);
	die;
}

Title ('Tickets - '.$Site['nom']);
?>

<div class="coins">
    <p class="coins">
        <em>Les tickets vous permettent de participer à des tombolats</em>
        <strong><?=number_format($User['coins'], 2, ',', ' ');?></strong>
    </p>

    <form method="post">
        <input type="number" name="charge" placeholder="Recharger..." />
        <input type="submit" value="OK" />
    </form>
</div>