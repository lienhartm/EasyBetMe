<?php

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

$dateTo = date('Y-m-d');

$filename = "/homepages/18/d864215150/htdocs/monwebpro.com/sites/easybet/templates/cron-tab-1/data/footnews-$dateTo.json";

// Vérifie si le fichier existe
if (!file_exists($filename)) {
    //die("Fichier introuvable : $filename");
    die("<h3 style='margin: 100px auto;'>Veuillez nous excuser pour la gêne occasionnée !<br /> Les actualités seront bientôt à l'affiche !</h3>");
}

// Lire le contenu du fichier
$jsonContent = file_get_contents($filename);

// Décoder le JSON
$data = json_decode($jsonContent, true);

if ($data['status'] === 'ok' && !empty($data['articles'])) {
    echo '<style>
    body { font-family: Arial, sans-serif; background: #f5f5f5; margin: 20px; }
    .article-card { background: #fff; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); max-width: 700px; margin: 20px auto; overflow: hidden; display: flex; flex-direction: row; gap: 20px; }
    .article-image { width: 250px; object-fit: cover; }
    .article-content { padding: 15px 20px; flex-grow: 1; display: flex; flex-direction: column; }
    .article-title { font-size: 1.2em; margin: 0 0 10px; color: rgb(0,104,55); text-decoration: none; }
    .article-title:hover { text-decoration: underline; }
    .article-meta { font-size: 0.85em; color: #555; margin-bottom: 10px; }
    .article-description { flex-grow: 1; color: #333; }
    .read-more { align-self: flex-start; margin-top: 15px; padding: 8px 12px; background: rgb(0,104,45); color: white; text-decoration: none; border-radius: 4px; font-size: 0.9em; }
    .read-more:hover { background: rgb(0,104,55); }
    .news {display: grid;  grid-template-columns: auto auto auto; gap: 10px;  padding: 10px;}
    .news > div {  background-color: #f1f1f1; color: #000;  padding: 10px;  text-align: center;}
    h3 { font-weight:bold; text-align:center;}
    </style><h3>Les dernières actualités sur le football !</h3><div class ="news">';

    foreach ($data['articles'] as $article) {
        $title = htmlspecialchars($article['title']);
        $url = htmlspecialchars($article['url']);
        $image = htmlspecialchars($article['urlToImage'] ?? '');
        $source = htmlspecialchars($article['source']['name'] ?? 'Inconnu');
        $description = htmlspecialchars($article['description'] ?? '');
        // Format date en français (ex: 16 juin 2025)
        /*
        setlocale(LC_TIME, 'fr_FR.UTF-8');
        $timestamp = strtotime($article['publishedAt']);
        $publishedAt = strftime('%d %B %Y', $timestamp);
        */
        // Formatage de la date en français (ex: 16 juin 2025)
        $timestamp = strtotime($article['publishedAt']);
        $date = new DateTime();
        $date->setTimestamp($timestamp);
        // Création d'un formateur de date en français
        $locale = 'fr_FR';  // Langue : français
        $formatter = new IntlDateFormatter($locale, IntlDateFormatter::LONG, IntlDateFormatter::NONE);
        // Formatage de la date
        $publishedAt = $formatter->format($date);

        echo '<div class="article-card">';
        if ($image) {
            echo '<img src="'.$image.'" alt="Image article" class="article-image" />';
        }
        echo '<div class="article-content">';
        echo '<a href="'.$url.'" target="_blank" class="article-title">'.$title.'</a>';
        echo '<div class="article-meta">Source : '.$source.' — Publié le '.$publishedAt.'</div>';
        echo '<p class="article-description">'.$description.'</p>';
        echo '<a href="'.$url.'" target="_blank" class="read-more">Lire la suite</a>';
        echo '</div></div>';
    }

    echo '</div>';
} else {
    echo "Aucun article disponible.";
}

// color:rgb(0,104,55)