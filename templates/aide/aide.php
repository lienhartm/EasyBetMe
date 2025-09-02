<p>Chaque jour <strong><?=$Site['nom'];?></strong> propose un événement (sportif, politique, autre).</p>
<? if ($_SESSION['login']!=1): ?>
<p><a href="<?$Url;?>/login">Inscrivez-vous ou connectez-vous</a> sur le site et faites votre pronostic quotidien.</p> 
<? endif; ?>
<p><strong>1 pronostic = 1 crédit</strong>. Les crédits disponibles pour chaque utilisateur sont matérialisés par ce symbole <span class="icon">&#xe939;</span>.</p>
<p>A l'inscription, vous recevez automatiquement 10 crédits pour jouer librement sur le site.</p>
<p>Pour recharger vos crédits, il suffit de choisir l'<a href="<?=$Url;?>/credits">une des formules proposées sur le site</a>.</p>
<p>Chaque membre peut effectuer <strong>un seul pronostic par jour</strong>. Une fois le pronostic effectué, il n'est plus possible de le modifier.</p>
<p>Les pronostics sont ouverts jusqu'à la dernière minute avant le début de l'événement. Une fois l'événement commencé, il n'est plus possible de faire un pronostic.</p>
<p>Il est possible de faire un pronostic par jour. 3 points de victoire sont attribués si le score prédit est exact, 1 point si l'issue du jeu a été trouvée (victoire de l'équipe à domicile, des visiteurs ou match nul).</p>
<p>Les points servent à vous classer parmis les joueurs et tenter de remporter des lots. Rendez-vous sur la <a href="<?=$Url;?>/points">page points</a> pour connaître votre position et le(s) lot(s) actuel(s).</p>
<p>En cas de pénaltys, le score retenu pour le décompte des points est celui en fin du temps réglementaire. Les buts inscrits lors des séances de tir aux buts ne sont donc pas pris en compte. Si un match est reporté, le score retenu pour le décompte des points est 0-0.</p>
<p><strong><?=$Site['nom'];?></strong> se veut avant tout un site de divertissement et propose une alternative aux jeux d'argent pouvant dévlopper l'addiction. Pour plus d'informations conculter les <a href="<?=$Url;?>/cgv">CGV</a> du site.</p>
