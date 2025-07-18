<?php 

    $_SESSION['login']=0; 

    $Site = ['nom' => 'EasyBet.me', 'url'=>'127.0.0.1'];
    //$User = ['id' => 31];
    $Url = $Site['url'];

?>
<!doctype html>
<html>
<head>
	<title><?php echo $Site['nom']; ?></title>

    <link rel="canonical" href="" />
    <link rel="icon" href="/images/favicon.ico" />
    <link rel="shortcut icon" sizes="192x192" href="/images/favicon192.png" />
    <link rel="apple-touch-icon" href="/images/favicon192.png" />

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Caprasimo&family=Orbitron:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <link href="/styles/knacss.css" rel="stylesheet" type="text/css" />
    <link href="/styles/styles.css" rel="stylesheet" type="text/css" />

    <meta charset="utf-8" />
    <meta http-equiv="content-language" content="fr" />
    <meta name="description" content="Jouez gratuitement chaque jour, faites votre pronostic et gagnez des cadeaux ! " />
    <meta name="keywords" content="" />
    <meta name="copyright" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta property="og:url"           content="" />
    <meta property="og:type"          content="website" />
    <meta property="og:title"         content="" />
    <meta property="og:description"   content="" />
    <meta property="og:description"   content="Jouez gratuitement chaque jour, faites votre pronostic et gagnez des cadeaux !" />
    <meta property="og:image"         content="/images/images/about.jpg" />    

    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-NSD9NVD7WK"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'G-NSD9NVD7WK');
    </script>

    <script type="application/ld+json">
        {
        "@context": "https://schema.org",
        "@type": "Game",
        "@name": "<?=$Site['name'];?>",
        "@url": "<?=$Url;?>",
        "@logo": "/images/logo-easybet.png",
        "description": "Jouez gratuitement chaque jour, faites votre pronostic et gagnez des cadeaux !"
        }
    </script>
</head>
<body class="football">
<header>
	<h1 onclick="document.location.href='<?=$Url?>'"><img src="/images/logo-easybet.png" alt="esayBet - Welcome" /></h1>

	<nav>
	<?
    $help = '&#xea09;';
    $help = '&#xe941;';
    ?>
    <a href="/aide"><span class="icon"><?=$help;?></span></a>
    <a href="/informations"><i class="fa fa-soccer-ball-o" style="padding:13px;font-size:22px;color:rgb(0,104,55);" ></i></a>
    <a href="/news"><i class="fa" style="padding:13px;font-size:22px;color:rgb(0,104,55);">&#xf1ea;</i></a>
	<? if($_SESSION['login']==1 && ($User['id']==1 || $User['id']==2  || $User['id']==31)):?>
	    <a href="/admin"><span class="icon">&#xe994;</span></a>
	<? endif; ?>
	<? if($_SESSION['login']==1):?>
	    <a href="/gift"><span class="icon">&#xe99f;</span><label><?=$User['gift'];?></label></a>
	<? endif; ?>
	<? if($_SESSION['login']==1):?>
	    <a href="/penalty"><span class="icon">&#xe915;</span></a>
	<? endif; ?>
	<? $nav_link = ($_SESSION['login']==1) ? $Url.'/profile' : $Url.'/login'; ?>
	<a href="<?=$nav_link;?>"><span  class="icon">&#xe971;</span></a>
</nav>

</header>
<div class="gradient"></div>
<main>
	<?php $contenu ?>
</main>
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
