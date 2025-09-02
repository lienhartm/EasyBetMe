	<footer>
		<?php
			echo '<p>';
				echo date("Y",time()).' Copyright ©easyBet.me <span class="trait">-</span> ';
				echo '<a href="'.$Url.'/mentions-legales">Mentions légales</a> <span class="trait">-</span> ';
				echo '<a href="'.$Url.'/cgv">Conditions générales de vente</a>';
			echo '</p>';
		?>
	</footer>
</body>
</html>

<? include $Tools.'/cookies.php'; ?>