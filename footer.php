	<footer>
		<div class="footer">
			<div class="column">
				<a href="<?$Url?>" ><img src="https://www.easybet.me/images/logo-easybet.png" alt="esayBet - Welcome">
				<a href="<?$Url?>/mentions-legales">Mentions légales</a>
				<a href="<?$Url?>/cgv">Conditions générales de ventes</a>
				<a href="<?$Url?>/contact">Contactez-nous</a>
			</div>

			<div class="column">
				<a href="<?$Url?>/competitions">Competitions</a>
				<a href="<?$Url?>/inscription">Incriptions</a>
				<a href="<?$Url?>/credits">Crédits</a>
				<a href="<?$Url?>/aide">Aide</a>
			</div>
		</div>

		<h6><?=date("Y",time())?> Copyright ©easyBet.me</h6>
	</footer>
</body>
</html>

<?php include $Tools.'/cookies.php'; ?>

<style>

	.footer {
		display:flex;
		justify-content:space-around;
	}

	.column {
		display:flex;
		flex-direction:column;
		color:black;
	}
	h6 {
		text-align:center;
		color:black;
		font-size:10px;
	}

</style>