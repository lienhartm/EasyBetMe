
<br />
<br />
<div id="easybet" class="titleAide">
    <img src="https://www.easybet.me/images/logo-easybet.png" alt="esayBet - Welcome">
</div>
<br />
    <p class="titleAide"><strong><?=ucfirst($Site['nom']). " ";?></strong>&nbsp;propose un ou plusieurs événements sportif de football selon les matches officiels</p>
<br />
<br />
<blockquote>
    <h4>Sommaire:</h4>
    <ul>
        <li><a href='#credits' >I. Crédits</a></li>
        <li><a href='#pronostique' >II. Pronostique</a></li>
        <li><a href='#competitions' >III. Compétitions</a></li>
        <li><a href="#penalty">IV. Mini-Jeu de Pénaltys</a></li>
        <li><a href='#ameliorations' >IV. Améliorations</a></li>
    </ul>

</blockquote>
<br />
<br />
<? if ($_SESSION['login']!=1): ?>
    <br />
    <br />
<p class="login blink">>>> <a href="<?$Url;?>/login">Inscrivez-vous ou connectez-vous</a> sur le site et faites votre pronostic quotidien <<<</p> 
    <br />
<? endif; ?>
<br />
<br />
<h3 id='credits' class="h3">I. Crédits</h3>
<br />
<p>Les crédits disponibles pour chaque utilisateur sont matérialisés par ce symbole <span class="icon">&#xe939;</span>. A l'inscription, vous recevez automatiquement 10 crédits pour jouer librement sur le site.</p>
<br />
<p class="pronos"><strong><span class="icon">&#xe939;</span> 1 pronostic = 1 crédit <span class="icon">&#xe93b;</span></strong></p>
<br />
<p>Pour recharger vos crédits, il suffit de choisir l'<!--<a href="<?=$Url;?>/credits">-->une des formules proposées sur le site</a>. Grille tarifaire pour l'achat des crédits:</p>
<br />
<div class="credits">
    <div class="credit">
        <p class="head"><strong>CRÉDITS DISPONIBLES</strong></p>
        <p class="number">25</p>
    </div>

    <div class="credit">
      <h2 class="title"><strong>RECHARGER</strong></h2>
      <div class="charge">
          <p class="offre"><strong>1 CREDIT</strong></p>
          <p class="number"> 1,00&nbsp;&euro;</p>
          <p class="note"></p>
      </div>
      <div class="charge">
          <p class="offre"><strong>5 CREDITS</strong></p>
          <p class="number"> 3,00&nbsp;&euro;</p>
          <p class="note">(2 crédits offerts)</p>
      </div>
      <div class="charge">
          <p class="offre"><strong>10 CREDITS</strong></p>
          <p class="number"> 5,00&nbsp;&euro;</p>
          <p class="note">(5 crédits offerts)</p>
      </div>
    </div>
</div>
<br />
<a class="retour"  href="#easybet">⟰ Retour</a>
<br />
<h3 id='pronostique' class="h3">II. Pronostique</h3>
<br />
<p>Chaque membre peut effectuer <strong>un seul pronostic par jour</strong>. Une fois le pronostic effectué, il n'est plus possible de le modifier. Les pronostics sont ouverts jusqu'à la dernière minute avant le début de l'événement. 
Une fois l'événement commencé, il n'est plus possible de faire un pronostic. Il est possible de faire un pronostic par jour. 3 points de victoire sont attribués si le score prédit est exact, 
1 point si l'issue du jeu a été trouvée (victoire de l'équipe à domicile, des visiteurs ou match nul). Un délai d'attente de 80 heures après le début de la rencontre est recommandé par le jury pour l'attribution des points si le pari est gagné.
Les points servent à vous classer parmis les joueurs et tenter de remporter des lots. Rendez-vous sur la <!--<a href="<?=$Url;?>/points">page points</a>--> pour connaître votre position et le(s) lot(s) actuel(s).</p>
<br />
<p class='titleAide'>Panneau utilisateur:</p>
<br />
<div class="points">
    <div class="bloc" id="position">
        <p class="head">Classement:</p>
        <p class="icon">&#xe9d9;</p>
        <p class="main">2/26</p>
    </div>        
    <div class="bloc" id="points">
        <p class="head">Points:</p>
        <p class="icon">&#xe99e;</p>
        <p class="main">3</p>
    </div>
    <div class="bloc" id="credits">
        <p class="head">Crédits:</p>
        <p class="icon">&#xe93b;</p>
        <p class="main">25</p>
    </div>
    <div class="bloc" id="pronos">
        <p class="head">Parties:</p>
        <p class="icon">&#xe939;</p>
        <p class="main">2</p>
    </div>
    <div class="bloc" id="cadeaux">
        <p class="head">À gagner:</p>
        <p class="icon">&#xe99f;</p>
        <p class="main">Voir</p>
    </div>
    <div class="bloc" id="motdepasse">
        <p class="head">Mot de passe:</p>
        <p class="icon">&#xe98d;</p>
        <p class="main">Modifier</p>
    </div>
</div>
<br />
<p>
    En cas de pénaltys, le score retenu pour le décompte des points est celui en fin du temps réglementaire. 
    Les buts inscrits lors des séances de tir aux buts ne sont donc pas pris en compte. 
    Si un match est reporté, le score retenu pour le décompte des points est 0-0. 
    <strong><?=ucfirst($Site['nom']);?></strong>
     se veut avant tout un site de divertissement et propose une alternative aux jeux d'argent pouvant dévlopper l'addiction. 
    Pour plus d'informations conculter les 
    <a href="<?=$Url;?>/cgv">CGV</a> du site.
</p>
<br />
<a class="retour"  href="#easybet">⟰ Retour</a>
<br />
<h3 id='competitions' class="h3">III. Compétitions</h3>
<br />
<p class="titleAide">Compétitions suivi par<strong>&nbsp;<?=ucfirst($Site['nom']);?></strong>:</p>
<br />
<table class="competitions">
    <tr>
        <th>Country</th>
        <th>Name</th>
        <th>Type</th>
    </tr><!--
    <tr>
        <td>Brazil</td>
        <td>Campeonato Brasileiro Série A</td>
        <td>LEAGUE</td>
    </tr>-->
    <tr>
        <td>England</td>
        <td>Premier League</td>
        <td>LEAGUE</td>
    </tr><!--
    <tr>
        <td>England</td>
        <td>Championship</td>
        <td>LEAGUE</td>
    </tr>--><!--
    <tr>
        <td>Europe</td>
        <td>European Championship</td>
        <td>CUP</td>
    </tr>-->
    <tr>
        <td>Europe</td>
        <td>UEFA Champions League</td>
        <td>CUP</td>
    </tr>
    <tr>
        <td>France</td>
        <td>Ligue 1</td>
        <td>LEAGUE</td>
    </tr>
    <tr>
        <td>Germany</td>
        <td>Bundesliga</td>
        <td>LEAGUE</td>
    </tr>
    <tr>
        <td>Italy</td>
        <td>Serie A</td>
        <td>LEAGUE</td>
    </tr><!--
    <tr>
        <td>Netherlands</td>
        <td>Eredivisie</td>
        <td>LEAGUE</td>
    </tr>--><!--
    <tr>
        <td>Portugal</td>
        <td>Primeira Liga</td>
        <td>LEAGUE</td>
    </tr>--><!--
    <tr>
        <td>South America</td>
        <td>Copa Sudamericana</td>
        <td>CUP</td>
    </tr>-->
    <tr>
        <td>Spain</td>
        <td>Primera Division</td>
        <td>LEAGUE</td>
    </tr>
    <tr>
        <td>World</td>
        <td>FIFA World Cup</td>
        <td>CUP</td>
    </tr>
</table>
<br />
<a class="retour"  href="#easybet">⟰ Retour</a>
<br />
<h3 id="penalty" class="h3">IV. Mini-Jeu de Pénaltys</h3>
<br />
<p>
    Le jeu de tirs au but est développé simplement en HTML, CSS et JavaScript. Concernant le gameplay, l’objectif principal de ce jeu est de marquer des buts en un nombre d’essais donné. Il n’y a pas de limite de temps, il suffit de bien ajuster la position du ballon et la puissance du tir. Le joueur doit contrôler la barre avec le curseur de la touche 'space' et appuyer sur la touche 'space' pour tirer.
</p>
<p>
    Ce mini-jeu de pénaltys est un jeu d'adresse où les joueurs peuvent gagné des crédits en tirant des pénaltys. A chaque partie le joueur dispose de 5 tirs, et le but est de marquer le plus de buts possible. Le score est ensuite crédité sur votre compte de tel sorte :
</p>
<ul>
    <li>1 but = 1 crédit</li>
    <li>2 buts = 2 crédits</li>
    <li>3 buts = 3 crédits</li>
    <li>4 buts = 4 crédits</li>
    <li>5 buts = 5 crédits</li>
</ul>
<div class="titleAide">
    <img src="https://www.easybet.me/images/Penalty-Shootout-Game-in-JavaScript.png" alt="Mini-Jeu de Pénaltys" style="  margin: 50px auto;width: 500px; height: auto; border-radius: 10px; box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);">
</div>
<p>
    Tout est très simple. Il suffit d’utiliser la touche 'space' pour viser et d'appuyer pour tirer. Ce jeu de sport est codé entièrement en JavaScript. Toutes les fonctionnalités du jeu sont implémentées en JavaScript, tandis que HTML et CSS sont utilisés pour la structure et le design. Des images et fichiers audio sont intégrés pour améliorer les graphismes et l’expérience de jeu.
</p>
<p>Nous recommandons d’utiliser des navigateurs modernes comme Google Chrome ou Mozilla Firefox. Le jeu peut également fonctionner sur Internet Explorer ou Microsoft Edge.
<br />Le projet Penalty Shootout Game en JavaScript avec code source est gratuit à télécharger et à utiliser uniquement à des fins éducatives.
</p>
<br />
<a class="retour"  href="#easybet">⟰ Retour</a>
<br />
<h3 id='ameliorations' class="h3">V. Proposition d'Amélioration</h3>
<ul>
    <br />
    <li>V.i Présentation</li>
    <p>
        <strong><?=ucfirst($Site['nom']);?></strong>&nbsp;
        permet aux joueurs de faire des pronostics sur divers événements. 
        Chaque joueur peut placer un pari par jour, en utilisant un crédit par pari.
        Les crédits peuvent être achetés via la plateforme et permettent de participer aux pronostics. 
        Les points sont totalisés le lendemain après le jour du coup d'envoi de l'événement.
        Les points accumulés peuvent être échangés contre des cadeaux de valeurs variées, selon un système de mise et vous est propre.</p>
    <br />
    <br />
    <li>V.ii Événements</li>
    <p>
        Les événements périodiques sont soumis à l'acceptation des joueurs pour leur participation.
        Les points gagnés hors périodique peuvent être convertis en crédits selon la règle suivante :
    </p>
    <ul>
        <li>5 points => 2 crédits</li>
        <li>10 points => 5 crédits</li>
    </ul>
    <br />
    <p>
        Lors d'un événement périodique, un classement est établi pour déterminer un gagnant. Si plusieurs
        joueurs obtiennent le même nombre de points, le départage se fait comme suit :
    </p>
    <ul>
        <li>1. Celui ayant le plus de paris gagnés par score exact.</li>
        <li>2. Celui ayant le plus de paris gagnés par issue du match (victoire, nul, défaite).</li>
        <li>3. Celui ayant participé à tous les matchs de l'événement.</li>
        <li>4. En cas d'égalité stricte, celui ayant gagné par issue sur tous les matchs remporte l'événement.</li>
    </ul>
    <br />
    <p>
        Le premier du classement se verra attribuer un cadeau. Les points gagnés à la fin de l'événement
        seront ajoutés aux points généraux du joueur. Chaque événement est unique, et les points démarrent
        à zéro à chaque nouvelle période.
    </p>
    <br />
    <br />
    <li>V.iii Aide</li>
    <p>
        Ce document doit fournir une explication claire et concise des fonctionnalités du site. Toutes les
        actions disponibles pour les joueurs doivent être mentionnées de manière structurée et explicite.
    </p>
    <br />
    <br />
    <li>V.iv Administration</li>
    <p>Les administrateurs ne créent pas directement les matchs, mais gèrent :</p>
    <ul>
        <li>L'ouverture des événements.</li>
        <li>La boutique des cadeaux et l'attribution des lots.</li>
        <li>La modération des litiges liés aux lots et aux classements.</li>
        <li>La révocation ou le blocage des comptes en cas de fraude ou de litige avéré.</li>
        <li>L'envoi de newsletters générales, individuelles ou de groupe.</li>
    </ul>
    <br />
    <br />
    <li>V.v Conclusion</li>
    <p>
        Ce document rassemble l'ensemble des propositions pour l'amélioration de&nbsp;
        <strong><?=ucfirst($Site['nom']);?></strong>. Il est
        essentiel de recueillir d'autres avis et retours pour affiner et développer davantage ce projet.
    </p>
</ul>
<br />
<a class="retour" href="#easybet">⟰ Retour</a>
<br />
<p>Vous pouvez toujours nous contactez pour nous apportez votre soutien au projet&nbsp;<strong><?=ucfirst($Site['nom']);?></strong>&nbsp;en écrivant par courriel à l'addresse suivante : contact@easybet.me</p>
<br />
<br />
<br />
<br />
<div class="thanks">
    <p>Merci de votre compréhension, l'équipe&nbsp;<strong><?=ucfirst($Site['nom']);?></strong>&nbsp;<p>
    <h3>&nbsp;<strong><?=ucfirst($Site['nom']);?>&nbsp;</h3>
</div>
<br />
<br />
<br />
<br />
<style>
    .h3 {
        background: #C0C0C0;
        padding: 5px;
    }
    li {
        font-size: 1.2em;
    }
    .blink {
        animation: blink-animation 1s infinite;
    }

    @keyframes blink-animation {
        0% { opacity: 1; }
        50% { opacity: 0; }
        100% { opacity: 1; }
    }
    a {
        text-decoration:none;
        color:black;
    }
    a.retour {
        float:right;
        margin-right:50px;
        text-decoration:underline;
    }
    .titleAide {
        display:flex;
        justify-content:center;
        background-color:white;
    }
    tr, th, td, table {
        border: 1px solid grey;   
        border-collapse: collapse;
        padding: 10px;
    }
    .points {
        width: 600px;
        height: 400px;
        margin: auto;
        display: grid;
        grid-gap: 10px;
        grid-template-columns: repeat(3, 1fr); 
    }

    .bloc {
        background: #f8f8f8;
        padding: 20px;
        border-radius: 10px;
        text-align: center;
        box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease-in-out;
    }

    .bloc:hover {
        transform: scale(1.05);
        background: #e0e0e0;
    }

    .head, .title {
        width: 100%;
        height: 30px;
        line-height: 30px;
        text-align: center;
        margin: 0;
        padding: 0;
        background: #333;
        color: #fff;
    }
    
    .title {
      margin: 10px 0 0 0;
    }

    .icon {
        font-size: 24px;
        margin-bottom: 5px;
    }
    .main {
        width: 100%;
        height: 70px;
        line-height: 70px;
        text-align: center;
        margin: 0;
        padding: 0;
        font-size: 2em;
        font-weight: bolder;
        color: rgb(0,104,55);
    }
    .pronos, .login {
      width:400px;
      margin:auto;
      text-align: center;
      background-color: #f8f8f8;
      padding: 10px;
      border-radius: 10px;
      border: 1px solid #ccc;
    }
    .competitions {
      margin: auto;
      width: 800px;
    }
    div.credits {
    background: #f8f8f8;
	width: 500px;
    height: auto;
    overflow: auto;
    display: block;
    margin: auto;
    padding: 0px;
    border: 1px solid black;
    border-collapse: collapse;
}
div.credits p.number {
    font-size: 3em;
    text-align: center;
    margin: 0;
    height: 50px;
    line-height: 50px;
    padding: 0 20px;
    font-weight: bold;
}
div.charge {
    margin: 10px;
}
p.offre {
    font-size: 1em;
    font-weight: bold;
    text-align:center;
    line-height: 25px;  
}
p.note {
    font-style: italic;
    font-size: 0.9em;
    color: #777;
    height:18px;
    line-height:18px;
    text-align:right;
    margin-right:20px;
}
table tr:nth-child(odd){background-color: #f2f2f2;}
.thanks {
    text-align:right;
    margin-right:150px;
}

@media only screen and (max-width: 600px) {
  div.credits {
    width: 100%;
  }
  div.points {
    width: 100%;
  }
}
</style>
