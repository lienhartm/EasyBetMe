<?php

ini_set('log_errors', 1);
ini_set('error_log', '/var/www/html/logfile/error_log.txt');
ini_set('error_reporting', E_ALL);

$time = date("d-m-Y H:i");

// journalisation des processus
function logMessage($message) {
    $logfile = '/var/www/html/logfile/cron_log.txt';
    file_put_contents($logfile, date('Y-m-d H:i:s') . " - " . $message . "\n", FILE_APPEND);
}

// enregistrement
logMessage(str_repeat("=", 49));
logMessage("Démarrage de la tâche cron - EasyBet Cron tab 1 - " . $time);
logMessage("| " . str_pad("Nb", 4) . " | " . str_pad("Url", 80) . " | " . str_pad("Filename", 40) . " | " . str_pad("Filesize", 10) . " | " . str_pad('Status', 8) . " |");

$a = 0;
date_default_timezone_set('Europe/Paris');
$year = date('Y');
$directory = "/var/www/html/data/";
$dateFrom = date('Y-m-d', strtotime('-1 day'));
$dateTo = date('Y-m-d');

// existence du répertoire
if (!is_dir($directory)) {
    $errorMessage = "Le répertoire $directory n'existe pas !";
    logMessage($errorMessage);
    die($errorMessage);
}

// fonction pour supprimer les fichiers plus vieux que 10 jours
$currentTime = time();
$files = scandir($directory);

foreach ($files as $file) {
    // Ignorer les dossiers '.' et '..'
    if ($file === '.' || $file === '..') {
        continue;
    }

    // Récupérer le chemin complet du fichier
    $filePath = $directory . DIRECTORY_SEPARATOR . $file;


    // Vérifier si c'est un fichier
    if (is_file($filePath)) {
        // Obtenir la date de la dernière modification du fichier
        $fileModificationTime = filemtime($filePath);

        // Vérifier si le fichier a été modifié il y a plus de 10 jours
        if ($currentTime - $fileModificationTime > 10 * 24 * 60 * 60) {
            // Supprimer le fichier
            if (unlink($filePath)) {
                logMessage("Le fichier $file a été supprimé.\n");
            } else {
                logMessae("Erreur lors de la suppression du fichier $file.\n");
            }
        }
    }
}

// fonction pour les requêtes
function matches(&$a, $token, $url, $filename, $directory) {

    $response = @file_get_contents($url, false, stream_context_create([
        'http' => ['method' => 'GET','header' => 'X-Auth-Token: ' .$token, 'timeout' => 10]
    ]));

    if ($response === FALSE) {
        logMessage("Erreur lors de l'accès à l'URL: $url");
        return;
    }

    ++$a;
    $data = json_decode($response, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        logMessage('Erreur lors du décodage du JSON : ' . json_last_error_msg());
        return;
    }

    $name = str_replace(".json", "", $filename); 
    // Commenter le 'SWITCH' pour récupérer la totalitée des données
    
    switch ($name) {
        case 'competitions':
            $filtered = array_filter($data['competitions'], function($comp) {
                return in_array($comp['code'], ['PL', 'CL', 'FL1', 'BL1', 'SA', 'PD', 'WC']);
            });
            $data['filters']['client'] = 'MonWebPro - EasyBet';
            $data['count']  = count($filtered);
            $data['competitions'] = array_values($filtered);
            break;
        default:
            $filtered = array_filter($data['matches'], function($match) {
                return in_array($match['competition']['code'], ['PL', 'CL', 'FL1', 'BL1', 'SA', 'PD', 'WC']);
            });
            $data['matches'] = array_values($filtered);
            break;
    }
    
    file_put_contents($directory . $filename, json_encode($data, JSON_PRETTY_PRINT));
    logMessage("| " . str_pad($a, 4) . " | " . str_pad($url, 80) . " | " . str_pad($filename, 40) . " | " . str_pad(filesize($directory . $filename), 10) . " | " . str_pad("ok", 8) . " |");

    sleep(10);
    
}
// URL
///// URL A CORRIGER POUR QUELLE SOIT DE LA MEME MANIERE QUE LES REQUETES DE COMPETITIONS
$token = '12cfafdf25fa4bfb9cd51b0a49432f31';

matches($a, $token, "https://api.football-data.org/v4/matches", "matches-".$dateTo.".json", $directory);
matches($a, $token, "https://api.football-data.org/v4/matches?dateFrom=" . $dateFrom . "&dateTo=" . $dateTo, "matches-$dateFrom.json", $directory);
matches($a, $token, "https://api.football-data.org/v4/competitions", "competitions.json", $directory);

function fetchData(&$a, $token, $url, $filename, $directory) {
    $reqPrefs = ['http' => ['method' => 'GET','header' => 'X-Auth-Token: ' . $token, 'timeout' => 10]];
    $response = @file_get_contents($url, false, stream_context_create($reqPrefs));

    if ($response === FALSE) {
        logMessage("Erreur lors de l'accès à l'URL: $url");
        return;
    }

    ++$a;
    $data = json_decode($response, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        logMessage('Erreur lors du décodage du JSON : ' . json_last_error_msg());
        return;
    }

    file_put_contents($directory . $filename, json_encode($data, JSON_PRETTY_PRINT));

    logMessage("| " . str_pad($a, 4) . " | " . str_pad($url, 80) . " | " . str_pad($filename, 40) . " | " . str_pad(filesize($directory . $filename), 10) . " | " . str_pad("ok", 8) . " |");
    sleep(10);
}

//sleep(10);

$competitions = ['PL', 'CL', 'FL1', 'BL1', 'SA', 'PD', 'WC'];

// Fetch competition data
foreach ($competitions as $code) {
    fetchData($a, $token, "https://api.football-data.org/v4/competitions/$code", "competition-info-$code.json", $directory);
    fetchData($a, $token, "https://api.football-data.org/v4/competitions/$code/matches?year=$year", "competition-matches-$code-$year.json", $directory);
    fetchData($a, $token, "https://api.football-data.org/v4/competitions/$code/standings?year=$year", "competition-standings-$code-$year.json", $directory);
    fetchData($a, $token, "https://api.football-data.org/v4/competitions/$code/scorers?year=$year", "competition-scorers-$code-$year.json", $directory);
}

//// récupération des dernières nouvelles de football !


$date = date('Y-m-d', strtotime('-1 day'));
$dateTo = date('Y-m-d'); // Correction du format de date
$apiKey = 'dcd3126ac90f4aab9585afd4b50c8703';
$directory = '/var/www/html/data/'; // Assurez-vous que ce répertoire existe
$baseUrl = 'https://newsapi.org/v2/everything';

// Paramètres de la requête
$queryParams = [
    'q' => 'football',
    'from' => $date,
    'to' => $date,
    'language' => 'fr',
    'sortBy' => 'publishedAt',
    'apiKey' => $apiKey
];

// Construction de l'URL avec les paramètres de requête
$url = $baseUrl . '?' . http_build_query($queryParams);

// Initialisation de cURL
$ch = curl_init();

// Définir les options de cURL
curl_setopt($ch, CURLOPT_URL, $url);             // L'URL de l'API
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  // Retourner le résultat sous forme de chaîne
curl_setopt($ch, CURLOPT_TIMEOUT, 30);           // Temps d'attente pour la requête (en secondes)
curl_setopt($ch, CURLOPT_USERAGENT, 'EasyBetMe - MonWebPro'); // Ajouter un User-Agent personnalisé

// Exécuter la requête cURL
$response = curl_exec($ch);

// Vérifier si une erreur s'est produite
if (curl_errno($ch)) {
    logMessage('Erreur cURL : ' . curl_error($ch));
    exit;
}

// Fermer la session cURL
curl_close($ch);

// Décoder la réponse JSON
$data = json_decode($response, true);

// Vérifier si la requête a réussi
if ($data['status'] === 'ok' && !empty($data['articles'])) {
    // Nom du fichier avec la date actuelle
    $filename = $directory . "footnews.json";

    // Enregistrer les articles dans un fichier JSON
    $jsonData = json_encode($data, JSON_PRETTY_PRINT);
    
    // Sauvegarder les données dans le fichier
    if (file_put_contents($filename, $jsonData)) {
        logMessage("| " . str_pad($a, 4) . " | " . str_pad($url, 86) . " |\n". str_pad(" ", 112) . "| " . str_pad($filename, 40) . " | " . str_pad(filesize($directory . $filename), 10) . " | " . str_pad("ok", 8) . " |");
    } else {
        logMessage( "Erreur lors de l'enregistrement des données dans le fichier.");
    }
} else {
    logMessage( "Aucune actualité trouvée ou erreur de l'API.");
}

/*
Mettre à jour les données dans la base de données
curl -X POST http://localhost:8080/index.php?action=home
*/

sleep(60);

$url = "http://localhost/";

$ch = curl_init();

// Configurer les options
curl_setopt($ch, CURLOPT_URL, $url);                 // Méthode POST
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);       // Retourner le résultat dans une variable

// Exécuter la requête
$response = curl_exec($ch);

// Vérifier s'il y a eu une erreur
if (curl_errno($ch)) {
    logMessage('Erreur cURL : ' . curl_error($ch));
} else {
    logMessage("Réponse du serveur : Mise à jour ok !");
}

// Fermer la session cURL
curl_close($ch);
$response = null;
$url = null;

logMessage(" ## Fin récupération des données ## ");

print_r($data);

?>

<!-- 

    FIN DE LA CRONTAB 
 
    exemple de logs du fichier cron_log.php :

2025-06-17 09:23:59 - =================================================
2025-06-17 09:23:59 - Démarrage de la tâche cron - EasyBet Cron tab 1 - 17-06-2025 09:23
2025-06-17 09:23:59 - | Nb   | Url                                                                              | Filename                                 | Filesize   | Status   |
2025-06-17 09:24:00 - | 1    | https://api.football-data.org/v4/matches                                         | matches-2025-06-17.json                  | 189        | ok       |
2025-06-17 09:24:11 - | 2    | https://api.football-data.org/v4/matches?dateFrom=2025-06-16&dateTo=2025-06-17   | matches-2025-06-16.json                  | 189        | ok       |
2025-06-17 09:24:21 - | 3    | https://api.football-data.org/v4/competitions                                    | competitions.json                        | 11164      | ok       |
2025-06-17 09:24:31 - | 4    | https://api.football-data.org/v4/competitions/PL                                 | competition-info-PL.json                 | 40868      | ok       |
2025-06-17 09:24:42 - | 5    | https://api.football-data.org/v4/competitions/PL/matches?year=2025               | competition-matches-PL-2025.json         | 814819     | ok       |
2025-06-17 09:24:52 - | 6    | https://api.football-data.org/v4/competitions/PL/standings?year=2025             | competition-standings-PL-2025.json       | 14696      | ok       |
2025-06-17 09:25:02 - | 7    | https://api.football-data.org/v4/competitions/PL/scorers?year=2025               | competition-scorers-PL-2025.json         | 11770      | ok       |
2025-06-17 09:25:12 - | 8    | https://api.football-data.org/v4/competitions/CL                                 | competition-info-CL.json                 | 10975      | ok       |
2025-06-17 09:25:23 - | 9    | https://api.football-data.org/v4/competitions/CL/matches?year=2025               | competition-matches-CL-2025.json         | 405999     | ok       |
2025-06-17 09:25:33 - | 10   | https://api.football-data.org/v4/competitions/CL/standings?year=2025             | competition-standings-CL-2025.json       | 25665      | ok       |
2025-06-17 09:25:44 - | 11   | https://api.football-data.org/v4/competitions/CL/scorers?year=2025               | competition-scorers-CL-2025.json         | 11887      | ok       |
2025-06-17 09:25:54 - | 12   | https://api.football-data.org/v4/competitions/FL1                                | competition-info-FL1.json                | 15978      | ok       |
2025-06-17 09:26:04 - | 13   | https://api.football-data.org/v4/competitions/FL1/matches?year=2025              | competition-matches-FL1-2025.json        | 654380     | ok       |
2025-06-17 09:26:14 - | 14   | https://api.football-data.org/v4/competitions/FL1/standings?year=2025            | competition-standings-FL1-2025.json      | 13259      | ok       |
2025-06-17 09:26:25 - | 15   | https://api.football-data.org/v4/competitions/FL1/scorers?year=2025              | competition-scorers-FL1-2025.json        | 11960      | ok       |
2025-06-17 09:26:35 - | 16   | https://api.football-data.org/v4/competitions/BL1                                | competition-info-BL1.json                | 26773      | ok       |
2025-06-17 09:26:46 - | 17   | https://api.football-data.org/v4/competitions/BL1/matches?year=2025              | competition-matches-BL1-2025.json        | 654622     | ok       |
2025-06-17 09:26:56 - | 18   | https://api.football-data.org/v4/competitions/BL1/standings?year=2025            | competition-standings-BL1-2025.json      | 13261      | ok       |
2025-06-17 09:27:07 - | 19   | https://api.football-data.org/v4/competitions/BL1/scorers?year=2025              | competition-scorers-BL1-2025.json        | 11890      | ok       |
2025-06-17 09:27:17 - | 20   | https://api.football-data.org/v4/competitions/SA                                 | competition-info-SA.json                 | 19998      | ok       |
2025-06-17 09:27:28 - | 21   | https://api.football-data.org/v4/competitions/SA/matches?year=2025               | competition-matches-SA-2025.json         | 729519     | ok       |
2025-06-17 09:27:38 - | 22   | https://api.football-data.org/v4/competitions/SA/standings?year=2025             | competition-standings-SA-2025.json       | 14412      | ok       |
2025-06-17 09:27:48 - | 23   | https://api.football-data.org/v4/competitions/SA/scorers?year=2025               | competition-scorers-SA-2025.json         | 460        | ok       |
2025-06-17 09:27:58 - | 24   | https://api.football-data.org/v4/competitions/PD                                 | competition-info-PD.json                 | 20094      | ok       |
2025-06-17 09:28:09 - | 25   | https://api.football-data.org/v4/competitions/PD/matches?year=2025               | competition-matches-PD-2025.json         | 818886     | ok       |
2025-06-17 09:28:19 - | 26   | https://api.football-data.org/v4/competitions/PD/standings?year=2025             | competition-standings-PD-2025.json       | 14686      | ok       |
2025-06-17 09:28:31 - | 27   | https://api.football-data.org/v4/competitions/PD/scorers?year=2025               | competition-scorers-PD-2025.json         | 12014      | ok       |
2025-06-17 09:28:41 - | 28   | https://api.football-data.org/v4/competitions/WC                                 | competition-info-WC.json                 | 16741      | ok       |
2025-06-17 09:28:51 - | 29   | https://api.football-data.org/v4/competitions/WC/matches?year=2025               | competition-matches-WC-2025.json         | 172438     | ok       |
2025-06-17 09:29:01 - | 30   | https://api.football-data.org/v4/competitions/WC/standings?year=2025             | competition-standings-WC-2025.json       | 24061      | ok       |
2025-06-17 09:29:11 - | 31   | https://api.football-data.org/v4/competitions/WC/scorers?year=2025               | competition-scorers-WC-2025.json         | 12298      | ok       |
2025-06-17 09:29:21 - | 32   | https://newsapi.org/v2/everything?q=football&language=fr&from=2025-06-17&to=2025-06-17&sortBy=publishedAt&apiKey=dcd3126ac90f4aab9585afd4b50c8703 | newsapi-football-2025-06-17.json         | 65         | ok       |
2025-06-17 09:29:21 -  ## Fin récupération des données ## 
2025-06-17 09:29:21 -  - ##### Fin de la tâche cron tab 1 ##### - 
2025-06-17 10:06:10 - =================================================

    exmple de logs du fichier error_log.php :

[14-May-2025 11:30:52 Europe/Berlin] PHP Warning:  Undefined variable $a in /homepages/18/d864215150/htdocs/monwebpro.com/sites/easybet/templates/cron-tab-1/index.php on line 81
[14-May-2025 11:36:04 Europe/Berlin] PHP Warning:  Undefined array key "alert_cookie" in /homepages/18/d864215150/htdocs/monwebpro.com/tools/cookies.php on line 2

-->