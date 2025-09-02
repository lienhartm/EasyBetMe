<?php
$page = isset($_GET['page']) ? htmlentities($_GET['page'],ENT_QUOTES,'utf-8') : null;
$data = isset($_GET['data']) ? htmlentities($_GET['data'],ENT_QUOTES,'utf-8') : null;
$niv3 = isset($_GET['niv3']) ? htmlentities($_GET['niv3'],ENT_QUOTES,'utf-8') : null;

include ('../../tools/statistiques.php');

$Pages = $db->query('SELECT * FROM pages WHERE titre_url = "'.$page.'" AND id_site = "'.$id_site.'"');
$Page = $Pages->fetch();
$nbPages = $Pages->rowCount();

$template = ($page=='') ? 'home' : $page;

$stats = $db->prepare('UPDATE pages SET ping = ping+1 WHERE titre_url = "'.$page.'" AND id_site = "'.$id_site.'"');
$stats->execute();

$canonical = $Url.$_SERVER['REQUEST_URI'];
?>
<!doctype html>
<html>
<head>
	<title><?php echo $Site['nom']; ?></title>

    <link rel="canonical" href="<?=$canonical;?>" />
	<link rel="icon" href="<?php echo '/images/favicon.ico'; ?>" />
    <link rel="shortcut icon" sizes="192x192" href="<?php echo $Url.'/images/favicon192.png'; ?>" />
	<link rel="apple-touch-icon" href="<?php echo '/images/favicon192.png'; ?>">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Caprasimo&family=Orbitron:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <link href="<?php echo $Url . '/styles/knacss.css'; ?>" rel="stylesheet" type="text/css" />
	<link href="<?php echo $Url .'/styles/styles.css?v='.time(); ?>" rel="stylesheet" type="text/css" />
	<link href="<?php echo $Url . '/styles/'.$template.'.css?v='.time(); ?>" rel="stylesheet" type="text/css" />

    <meta charset="utf-8" />
	<meta http-equiv="content-language" content="fr" />
	<!--<meta name="description" content="<?php echo $Page['meta_desc']; ?>" />-->
	<meta name="description" content="Jouez gratuitement chaque jour, faites votre pronostic et gagnez des cadeaux ! " />
	<meta name="keywords" content="<?php echo $Page['meta_keywords']; ?>" />
	<meta name="copyright" content="<?php echo $Nom; ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1">

    <meta property="og:url"           content="<?=$canonical;?>" />
    <meta property="og:type"          content="website" />
    <meta property="og:title"         content="<?=$Page['meta_title'];?>" />
    <!--<meta property="og:description"   content="<?=$Page['meta_desc'];?>" />-->
    <meta property="og:description"   content="Jouez gratuitement chaque jour, faites votre pronostic et gagnez des cadeaux !" />
    <meta property="og:image"         content="<?=$Url;?>/images/images/about.jpg" />    

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
        "@logo": "<?=$Url;?>/images/logo-easybet.png",
        "description": "Jouez gratuitement chaque jour, faites votre pronostic et gagnez des cadeaux !"
        }
    </script>
</head>
<body class="<?=($Categorie['categorie_url']!='') ? $Categorie['categorie_url'] : 'football';?>">
<header>
	<h1 onclick="document.location.href='<?=$Url;?>'"><img src="<?=$Url?>/images/logo-easybet.png" alt="esayBet - Welcome" /></h1>

	<?php include 'menu.php'; ?>
</header>