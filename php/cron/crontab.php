<!--
    DEBUT DU SCRIPT PHP * crontab.php *
-->
<?php

ini_set('log_errors', 1);
ini_set('error_log', '/var/www/html/logfile/error.log');
ini_set('error_reporting', E_ALL);

$time = date("d-m-Y H:i");

// journalisation des processus
function logMessage($message) {
    $logfile = '/var/www/html/logfile/cron.log';
    file_put_contents($logfile, date('Y-m-d H:i:s') . " - " . $message . "\n", FILE_APPEND);
}

// enregistrement
logMessage(str_repeat("=", 49));
logMessage("- ##### Démarrage de la tâche cron - EasyBet Crontab");
logMessage(str_repeat("=", 49));
logMessage("- ##### Gestion des fichiers de logs");
$logDir = '/var/www/html/logfile/';
$maxSize = 109400; // 100 Ko

try {

    // Vérifier si le répertoire existe
    if (!is_dir($logDir)) {
        throw new Exception("Le répertoire " . $logDir . " spécifié n'existe pas.\n");
    }

    // Ouvrir le répertoire
    $dir = opendir($logDir);
    if (!$dir) {
        throw new Exception("Impossible d'ouvrir le répertoire " . $logDir);
    }

    while (($file = readdir($dir)) !== false) {
        // Ignorer les répertoires "." et ".."
        if ($file == '.' || $file == '..') {
            continue;
        }

        $filePath = $logDir . '/' . $file;

        // Vérifier si c'est un fichier .log
        if (is_file($filePath) && pathinfo($file, PATHINFO_EXTENSION) == 'log') {
            $fileSize = filesize($filePath);

            // Si le fichier dépasse 100 Ko
            if ($fileSize + 7000 > $maxSize) {
                // Extraire le nom de base du fichier sans l'extension
                $baseName = pathinfo($file, PATHINFO_FILENAME);

                // Compter le nombre de fichiers sauvegardés existants
                $count = count(glob($logDir . '/' . $baseName . '*.log.save'));

                // Nouveau nom avec suffixe numérique
                $newName = $logDir . '/' . $baseName . '_' . $count . '.log.save';

                // Renommer le fichier
                if (!rename($filePath, $newName)) {
                    throw new Exception("Impossible de renommer le fichier '$file'.");
                }

                logMessage("Le fichier '$file' a été renommé en '$newName'\n");
            }
        }
    }

    // Fermer le répertoire
    closedir($dir);

} catch (Exception $e) {
    logMessage('Erreur : ' . $e->getMessage());
} finally {
    logMessage("- ##### Fin de la gestion des fichiers de logs");
}

    logMessage(str_repeat("=", 49));
    logMessage("- ##### Gestion des fichiers datas");

    $a = 0;
    date_default_timezone_set('Europe/Paris');
    $year = date('Y');
    $directory = "/var/www/html/data/";
    $dateFrom = date('Y-m-d', strtotime('-1 day'));
    $dateTo = date('Y-m-d');

try {
    // existence du répertoire
    if (!is_dir($directory)) {
        throw new Execption("Le répertoire $directory n'existe pas !");
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
                    logMessage("Le fichier $file a été supprimé.");
                } else {
                    throw new Exception("Erreur lors de la suppression du fichier $file.");
                }
            }
        }
    }

} catch (Exception $e) {
    logMessage('Erreur : ' . $e->getMessage());
} finally {
    logMessage("- ##### Fin de la gestion des fichiers datas");
}

logMessage(str_repeat("=", 49));
logMessage("- ##### Récupération des données API");
logMessage("| " . str_pad("Nb", 4) . " | " . str_pad("Url", 80) . " | " . str_pad("Filename", 40) . " | " . str_pad("Filesize", 10) . " | " . str_pad('Status', 8) . " |");

// fonction pour les requêtes
function matches(&$a, $token, $url, $filename, $directory) {

    try {
        $response = @file_get_contents($url, false, stream_context_create([
            'http' => ['method' => 'GET','header' => 'X-Auth-Token: ' .$token, 'timeout' => 10]
        ]));

        if ($response === FALSE) {
            throw new Exception("Erreur lors de l'accès à l'URL: $url");
        }

        ++$a;
        $data = json_decode($response, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception('Erreur lors du décodage du JSON : ' . json_last_error_msg());
        }

        $name = str_replace(".json", "", $filename); 
        // Commenter le 'SWITCH' pour récupérer la totalitée des données
        
        switch ($name) {
            case 'competitions':
                $filtered = array_filter($data['competitions'], function($comp) {
                    return in_array($comp['code'], ['PL', 'CL', 'FL1', 'BL1', 'SA', 'PD', 'WC']);
                });

                $data['competitions'] = array_values($filtered);

                foreach($data['competitions'] as $competition) {
                    $id = $competition['id'];
                    $code = $competition['code'];
                    $name = $competition['name'];
                    $emblem = $competition['emblem'];
                    $areaName = $competition['area']['name'];
                    $areaFlag = $competition['area']['flag'];
                    $startDate = $competition['currentSeason']['startDate'];
                    $endDate = $competition['currentSeason']['endDate'];
                    $currentMatchday = $competition['currentSeason']['currentMatchday'];

                    $file["competitions"][$id] = array(
                        "code" => $code,
                        "name" => $name,
                        "emblem" => $emblem,
                        "areaName" => $areaName,
                        "areaFlag" => $areaFlag,
                        "startDate" => $startDate,
                        "endDate" => $endDate,
                        "currentMatchday" => $currentMatchday
                    );

                }

                //$path = "../json/competitions.json";

                //$ctrl->writeJson($path, $file);

                break;
            default:
                $filtered = array_filter($data['matches'], function($match) {
                    return in_array($match['competition']['code'], ['PL', 'CL', 'FL1', 'BL1', 'SA', 'PD', 'WC']);
                });
                $file['matches'] = array_values($filtered);
                break;
        }


        
        if(!file_put_contents($directory . $filename, json_encode($file, JSON_PRETTY_PRINT))) {
            throw new Exception("Erreur lors de l'écriture dans le fichier $filename");
        }

        logMessage("| " . str_pad($a, 4) . " | " . str_pad($url, 80) . " | " . str_pad($filename, 40) . " | " . str_pad(filesize($directory . $filename), 10) . " | " . str_pad("ok", 8) . " |");

        sleep(10);
    } catch (Exception $e) {
        logMessage('Erreur : ' . $e->getMessage());
    }
    
}
// URL
///// URL A CORRIGER POUR QUELLE SOIT DE LA MEME MANIERE QUE LES REQUETES DE COMPETITIONS
$token = '12cfafdf25fa4bfb9cd51b0a49432f31';

matches($a, $token, "https://api.football-data.org/v4/matches", "matches-".$dateTo.".json", $directory);
matches($a, $token, "https://api.football-data.org/v4/matches?dateFrom=" . $dateFrom . "&dateTo=" . $dateTo, "matches-$dateFrom.json", $directory);
matches($a, $token, "https://api.football-data.org/v4/competitions", "competitions.json", $directory);

function fetchData(&$a, $token, $url, $filename, $directory) {
    try {
        $reqPrefs = ['http' => ['method' => 'GET','header' => 'X-Auth-Token: ' . $token, 'timeout' => 10]];
        $response = @file_get_contents($url, false, stream_context_create($reqPrefs));

        if ($response === FALSE) {
            throw new Exception("Erreur lors de l'accès à l'URL: $url");
        }

        ++$a;
        $json = json_decode($response, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception('Erreur lors du décodage du JSON : ' . json_last_error_msg());
        }

        $state = explode("-",$filename)[0];

        switch($state) {
            case 'standings':

                $data['standings'] = $json['standings'][0]['table'];

                break;
            case 'scorers':
                $date = null;
                foreach($json['scorers'] as $scorer) {
                    $firstName = $scorer['player']['firstName'];
                    $lastName = $scorer['player']['lastName'];
                    $playerTeamCrest = $scorer['team']['crest'];
                    $playedMatches = $scorer['playedMatches'];
                    $goals = $scorer['goals'];
                    $assists = $scorer['assists'];
                    $penalties = $scorer['penalties'];

                    $data['scorers'][] = array(
                        "firstName" => $firstName,
                        "lastName" => $lastName,
                        "playerTeamCrest" => $playerTeamCrest,
                        "playedMatches" => $playedMatches,
                        "goals" => $goals,
                        "assists" => $assists,
                        "penalties" => $penalties
                    );
                };

                break;
            case 'matches':

                $date = null;
                foreach($json['matches'] as $matche) {
                    $id = $matche['id'];
                    $utcDate = $matche['utcDate'];
                    $status = $matche['status'];
                    $homeTeamName = $matche['homeTeam']['name'];
                    $awayTeamName = $matche['awayTeam']['name'];
                    $homeTeamCrest = $matche['homeTeam']['crest'];
                    $awayTeamCrest = $matche['awayTeam']['crest'];
                    $scoreWinner = $matche['score']['winner'];
                    $scoreFullTimeHome = $matche['score']['fullTime']['home'];
                    $scoreFullTimeAway = $matche['score']['fullTime']['away'];

                    $data['matches'][$id] = array(
                        "utcDate" => $utcDate,
                        "status" => $status,
                        "homeTeamName" => $homeTeamName,
                        "awayTeamName" => $homeTeamName,
                        "homeTeamCrest" => $homeTeamCrest,
                        "awayTeamCrest" => $awayTeamCrest,
                        "scoreWinner" => $scoreWinner,
                        "scoreFullTimeHome" => $scoreFullTimeHome,
                        "scoreFullTimeAway" => $scoreFullTimeAway
                    );

                }

                break;
            case 'info':

                $date = null;
                foreach($json['seasons'] as $season) {
                    if($season['winner'] != null) {
                        $startDate = $season['startDate'];
                        $endDate = $season['endDate'];
                        $winnerName = $season['winner']['name'];
                        $winnerCrest = $season['winner']['crest'];

                        $data['seasons'][] = array(
                            "startDate" => $startDate,
                            "endDate" => $endDate,
                            "winnerName" => $winnerName,
                            "winnerCrest" => $winnerCrest
                        );

                    }

                }

                //$path = "../json/seasons-". $code . ".json";

                break;
            default:
                throw new Exception('No files');
                break;

        }

        if(!file_put_contents($directory . $filename, json_encode($data, JSON_PRETTY_PRINT))) {
            throw new Exception("Erreur lors de l'écriture dans le fichier $filename");
        }

        logMessage("| " . str_pad($a, 4) . " | " . str_pad($url, 80) . " | " . str_pad($filename, 40) . " | " . str_pad(filesize($directory . $filename), 10) . " | " . str_pad("ok", 8) . " |");
        sleep(10);
    } catch (Exception $e) {
        logMessage('Erreur : ' . $e->getMessage());
    }
}

$competitions = ['PL', 'CL', 'FL1', 'BL1', 'SA', 'PD', 'WC'];

// Fetch competition data
foreach ($competitions as $code) {
    fetchData($a, $token, "https://api.football-data.org/v4/competitions/$code", "info-$code.json", $directory);
    fetchData($a, $token, "https://api.football-data.org/v4/competitions/$code/matches?year=$year", "matches-$code.json", $directory);
    fetchData($a, $token, "https://api.football-data.org/v4/competitions/$code/standings?year=$year", "standings-$code.json", $directory);
    fetchData($a, $token, "https://api.football-data.org/v4/competitions/$code/scorers?year=$year", "scorers-$code.json", $directory);
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

try {

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
        throw new Exception('Erreur cURL : ' . curl_error($ch));
    }

    // Fermer la session cURL
    curl_close($ch);

    // Décoder la réponse JSON
    if(!$data = json_decode($response, true)) {
        throw new Exception('Erreur lors du décodage du JSON : ' . json_last_error_msg());
    };

    // Vérifier si la requête a réussi
    if ($data['status'] === 'ok' && !empty($data['articles'])) {
        // Nom du fichier avec la date actuelle
        $filename = "footnews.json";

        // Enregistrer les articles dans un fichier JSON
        $jsonData = json_encode($data, JSON_PRETTY_PRINT);
        
        // Sauvegarder les données dans le fichier
        if (!file_put_contents($directory . $filename, $jsonData)) {
            throw new Execption("Erreur lors de l'enregistrement des données dans le fichier $filename.");
        }

        ++$a;
        logMessage("| " . str_pad($a, 4) . " | " . str_pad($url, 86) . "   |\n...". str_pad(" ", 109) . "| " . str_pad($filename, 40) . " | " . str_pad(filesize($directory . $filename), 10) . " | " . str_pad("ok", 8) . " |");

    } else {
        throw new Exception( "Erreur : " . $data['status'] . " - " . $data['message'] );
    }

} catch (Exception $e) {
    logMessage('Erreur : ' . $e->getMessage());
} finally {
    logMessage("- ##### Fin récupération des données API");
}

logMessage(str_repeat("=", 49));
logMessage('- ##### Mise à jour de la base de données');

/// wait 10 secondes
sleep(10);

/*
Mettre à jour les données dans la base de données
curl -X POST http://localhost:8080/index.php?action=home
*/

// Nouvelle configuration de connexion
$db_server = 'db';  // Hôte de la base de données
$db_name = 'easybet';  // Nom de la base de données
$db_login = 'monwebpro';  // Identifiant utilisateur
$db_password = 'toor';  // Mot de passe8';

// conexion à la base de données avec gestion des erreurs
try {
	$db = new PDO('mysql:host='.$db_server.';dbname='.$db_name.';charset=utf8', $db_login, $db_password);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (PDOException $e) {
    $errorMessage = "Erreur de connexion à la base de données : " . $e->getMessage();
    logMessage($errorMessage);
    die($errorMessage);
}

$total = 0;

// Récupérer les paris en attente de résultat
try {
    $Paris = $db->query('SELECT * FROM easybet_bets WHERE result IS NULL AND DATE(date) != CURDATE()');
    $Paris = $Paris->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $errorMessage = "Erreur lors de la requête : " . $e->getMessage();
    logMessage($errorMessage);
    die($errorMessage);
}

// Récupérer l'event en cours
try {
    $currentDate = date('Y-m-d');
    $Events = $db->query('SELECT * FROM easybet_events ORDER BY datedebut ASC LIMIT 1');
    $Events = $Events->fetch(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $errorMessage = "Erreur lors de la requête : " . $e->getMessage();
    logMessage($errorMessage);
    die($errorMessage);
}

// Récupérer les gamers et leur classement
try {    
    $Gamers = $db->query('SELECT * FROM easybet_gamers ORDER BY event_points DESC');
    $Gamers = $Gamers->fetchAll(PDO::FETCH_ASSOC);
    if (isset($Gamers) && !empty($Gamers)) {
    $rank = 1;
    foreach ($Gamers as $key => &$gamer) {

        $gamer['rank'] = $rank;

        if (isset($Gamers[$key + 1]) && $Gamers[$key + 1]['event_points'] == $gamer['event_points']) {
            continue;
        }

        $rank++;
    }
}
} catch (Exception $e) {
    $errorMessage = "Erreur lors de la requête : " . $e->getMessage();
    logMessage($errorMessage);
    die($errorMessage);
}

try {

    if ($Paris) {

        foreach($Paris as $Pari) {

            $date = date("Y-m-d", strtotime($Pari['date']));

            $path = "/var/www/html/data/matches-" . date("Y-m-d", strtotime($Pari['date'])) . ".json";
        
            if (!file_exists($path)) {
                continue;
                // logMessage("Le fichier n'existe pas : " . $path);
                throw new Exception("Le fichier n'existe pas : " . $path);
            }
            
            $myfile = fopen($path, "r");

            if (!$myfile) {
                continue;
                // logMessage("Impossible d'ouvrir le fichier $path !");
                throw new Exception("Impossible d'ouvrir le fichier $path !");
            }

            $file = fread($myfile, filesize($path));
            fclose($myfile);
            $data = json_decode($file, true);

            $data = $data['matches'];
            
            if (json_last_error() !== JSON_ERROR_NONE) {
                continue;
                // logMessage('Erreur lors du décodage du JSON : ' . json_last_error_msg());
                throw new Exception('Erreur lors du décodage du JSON : ' . json_last_error_msg());
            }

            if ($Pari['result'] == null) {
                $points = '';

                foreach($data as $a) {

                    if (($a['score']['winner'] == null)) {
                        continue;
                    }

                    if ($a['id'] != $Pari['id_game']) {
                        continue;
                    }

                    switch ($a['score']['winner']) {
                        case 'HOME_TEAM': $PariBet = '1'; break;
                        case 'AWAY_TEAM': $PariBet = '2'; break;
                        case 'DRAW': $PariBet = 'N'; break;
                        default: $PariBet = null; break;
                    }

                    $update = $db->prepare('UPDATE easybet_bets SET result = :result WHERE id_game = :idGame');
                    $update->execute([':idGame' => $Pari['id_game'], ':result' => $PariBet]);

                    if ($Pari['bet'] === $PariBet) {
                        $points = 1;
                    }
                    elseif (($Pari['score_d'] === $a['score']['fullTime']['home']) && ($Pari['score_v'] === $a['score']['fullTime']['away'])) {
                        $points = 3;
                    }
                    else {
                        $points = 0;
                    }

                    $update = $db->prepare('UPDATE easybet_users SET points = points + :points, coins = coins + :points WHERE id = :userId');
                    $update->execute([
                        ':points' => $points,
                        ':userId' => $Pari['id_user'],
                    ]);

                    if($Events) {
                        if (date('Y-m-d') >= $Events['datedebut'] && date('Y-m-d') <= $Events['datefin'] && $Pari['date'] >= $Events['datedebut'] && $Pari['date'] <= $Events['datefin']) { // Si la date du pari est dans l'intervalle de l'événement date("Y-m-d", strtotime($Pari['date'])
                            
                            $updateGamer = $db->prepare('UPDATE easybet_gamers SET event_points = event_points + :coins WHERE id_user = :idUser');
                            $updateGamer->execute([
                                ':coins' => $points,
                                ':idUser' => $Pari['id_user'],
                            ]);
                        }
                    }

                    $PariBet = null;
                    $points = null;

                }
            }
        }
    }

} catch (Exception $e) {
    $errorMessage = "Erreur : " . $e->getMessage();
    logMessage($errorMessage);
    die($errorMessage);
}

if (isset($Events) && !empty($Events)) {
    if(date('Y-m-d') > $Events['datedebut']) {
        $gains = [ 1000, 500, 250, 100 ];
        foreach($gains as $gain) {
                
            for($i = 0; $i < 4; ++$i) {
                foreach($Gamers as $Gamer) {
                    if($Gamer['rank'] == $i) {
                        $update = $db->prepare('UPDATE easybet_gamers SET event_points = event_points + :coins WHERE id_user = :idUser');
                        $update->execute([
                            ':coins' => $gains[$i],
                            ':idUser' => $Gamer['id_user'],
                        ]);
                    }
                }
            }
        }

        try {
            // Supprimer les GAMERS
            $delete = $db->prepare('DELETE FROM easybet_gamers');
            if(!$delete->execute()) {
                throw new Exception("Erreur lors de la suppression des gamers !");
            }
            // Supprimer l' EVENTS
            $deleteEvent = $db->prepare('DELETE FROM easybet_events WHERE datefin < :datefin');
            if(!$deleteEvent->execute([':datefin' => date('Y-m-d')])) {
                throw new Exception("Erreur lors de la suppression de l'event !");
            }
            // Supprimer les BETS < 15 jours
            $deletePari = $db->prepare('DELETE FROM easybet_bets WHERE date < :date');
            if(!$deletePari->execute([':date' => date('Y-m-d', strtotime('-15 days'))])) {
                throw new Exception("Erreur lors de la suppression des paris !");
            }
        } catch (Exception $e) {
            $errorMessage = "Erreur lors de la requête : " . $e->getMessage();
            logMessage($errorMessage);
            die($errorMessage);
        }
    }
}

logMessage("- ##### Fin mise à jour de la base de données");
logMessage(str_repeat("=", 49));
/* test response page */
logMessage('- ##### Test de la page d\'accueil');

///// wait 10 secondes
sleep(10);

$url = "http://localhost/";

try {
    $ch = curl_init();

    // Configurer les options
    curl_setopt($ch, CURLOPT_URL, $url);                 // Méthode POST
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);       // Retourner le résultat dans une variable
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);               // Suivre les redirections (si applicable)
    curl_setopt($ch, CURLOPT_HEADER, true);                       // Inclure les en-têtes de réponse
    curl_setopt($ch, CURLOPT_NOBODY, false);                      // Télécharger le corps de la réponse (par défaut false)
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);                         // Délai d'attente maximal (en secondes)

    // Exécuter la requête
    $response = curl_exec($ch);

    // Vérifier s'il y a eu une erreur
    if (curl_errno($ch)) {
        throw new Exception('Erreur cURL : ' . curl_error($ch));
    } else {
        // Récupérer le code HTTP de la réponse
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $totalTime = curl_getinfo($ch, CURLINFO_TOTAL_TIME);  // Temps total pour la requête
        $connectTime = curl_getinfo($ch, CURLINFO_CONNECT_TIME);  // Temps pour établir la connexion
        $sizeDownload = curl_getinfo($ch, CURLINFO_SIZE_DOWNLOAD); // Taille des données téléchargées
        $headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);  // Taille des en-têtes

        // Séparer les en-têtes et le corps de la réponse
        $headers = substr($response, 0, $headerSize);
        $body = substr($response, $headerSize);

        // Affichage des informations collectées
        logMessage(str_pad("Réponse du serveur :", 27) . "Code HTTP = " . $httpCode);
        logMessage(str_pad("Temps de réponse total :", 27) . $totalTime. " secondes");
        logMessage(str_pad("Temps de connexion :", 27) . $connectTime . " secondes");
        logMessage(str_pad("Taille des données :",27) . $sizeDownload . " octets téléchargés");

        // Afficher les en-têtes de la réponse (si nécessaire)
        file_put_contents("/var/www/html/logfile/header.log", $headers);
        file_put_contents("/var/www/html/logfile/body.log", $body);

    }

    // Fermer la session cURL
    curl_close($ch);
} catch (Exception $e) {
    logMessage('Erreur : ' . $e->getMessage());
} finally {
    logMessage("- ##### Fin test de la page d'accueil");
}

$response = null;
$url = null;

logMessage(str_repeat("=", 49));
logMessage("- ##### Fin de la tâche cron - EasyBet Crontab");
logMessage(str_repeat("=", 49));

?>
<!--
    FIN DU SCRIPT PHP * crontab.php *
-->