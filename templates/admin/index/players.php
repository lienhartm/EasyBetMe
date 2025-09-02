<div class="players">
<p>
    <a href="<?=$Url;?>/admin/raz">RAZ</a>
     - <a href="<?=$Url;?>/admin/nl">NL</a>
     - <a href="<?=$Url;?>/admin/special">Spécial</a>
     - <a href="<?=$Url;?>/admin/publications">Publications</a>
     - <a href="<?=$Url;?>/admin/paris">Paris</a>
</p>

<ol>
<?
$Players = $db->query('SELECT * FROM easybet_users WHERE off=0 ORDER BY points DESC');
while ($Player = $Players->fetch()) {
    echo '<li>';
		echo '<a href="'.$Url.'/'.$page.'/player/'.$Player['id'].'">';
			echo '<span>'.$Player['pseudo'].'</span>';
			echo '<strong>'.$Player['points'].'</strong>';
		echo '</a>';
    echo '</li>';
}
?>
</ol>

<?
$Players = $db->query('SELECT * FROM easybet_users WHERE off=1 ORDER BY points DESC');
$nbPlayers = $Players->rowCount();
?>
<p>Non validés: <strong><?=$nbPlayers;?></p>
</div>