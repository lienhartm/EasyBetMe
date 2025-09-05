<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="../styles/_news.css" rel="stylesheet" type="text/css" />
<?php

    // temporisation de sortie
    ob_start();

    if(isset($data)) { $data = $data['articles']; }

    $search = $news_source = "";

?>

<h2>Les dernières actualités du football</h2>
<p>Les articles sont fournis par <a href="https://newsapi.org/" target="_blank" class="api">NewsAPI.org</a> via des sources telles que BBC Sport, ESPN, The Guardian, etc.</p>
<p>Pour permettre une recherche de l'actualité souhaité vous pouvez effectuer la selection du journal ou effectuer une recherche par mot clé car tous les articles ne sont pas affichés sur la page...</p>

<div class="tools">
    <form method="post" action="" id="searchForm">  
        <select name="news_source">
            <option value="">-- Choisir une source --</option>
            <?php
                $sources = [];
                foreach ($data as $article) {
                    if (isset($article['source']['name']) && !in_array($article['source']['name'], $sources)) {
                        $sources[] = $article['source']['name'];
                    }
                }
                sort($sources);
                foreach ($sources as $source) {
                    echo '<option value="'.htmlspecialchars($source).'">'.htmlspecialchars($source).'</option>';
                }
            ?>
            <option value=""></option>
        </select>
        <input type="text" name="search" placeholder="Rechercher un article..." />
        <button type="submit">Rechercher</button>
        <button type="reset" id="reset">Réinitialiser</button>

    </form>

    <div style="float:right;">
        <span>Affichage :</span>
        <button class="fa icon" id="grid">&#xf1a5;</button>
        <button class="fa icon" id="column">&#xf0c9;</button>
    </div>
</div>

<?php

    echo '<div class="news">';

    afficheData(array_slice($data, 0, 5));

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $search = htmlspecialchars($_POST['search']);
        $news_source = htmlspecialchars($_POST['news_source']);
        if ($search) {
            $data = array_filter($data, function($article) use ($search) {
                return stripos($article['title'], $search) !== false || stripos($article['description'] ?? '', $search) !== false;
            });
        }
        if ($news_source) {
            $data = array_filter($data, function($article) use ($news_source) {
                return isset($article['source']['name']) && $article['source']['name'] === $news_source;
            });
        }

        afficheData($data);
    
    }

    function afficheData($data) {
        foreach ($data as $article) {
            $title = htmlspecialchars($article['title']);
            $url = htmlspecialchars($article['url']);
            $image = htmlspecialchars($article['urlToImage'] ?? '');
            $source = htmlspecialchars($article['source']['name'] ?? 'Inconnu');
            $description = htmlspecialchars($article['description'] ?? '');
            $timestamp = strtotime($article['publishedAt']);
            $publishedAt = date('d/m/Y H:i:s', $timestamp);

            echo '<div class="article-card">';
            if ($image) {
                echo '<img src="'.$image.'" alt="Image article" class="article-image" />';
            }
            echo '<div class="article-content">';
            echo '<a href="'.$url.'" target="_blank" class="article-title">'.$title.'</a>';
            echo '<div class="article-meta">Source : '.$source.' — Publié le '.$publishedAt.'</div>';
            echo '<p class="article-description">'.$description.'</p>';
            echo '</div><a href="'.$url.'" target="_blank" class="read-more">Lire la suite</a></div>';
        }
    }
    echo '</div>';

    $contenu = ob_get_clean();

    require_once "template.php";

?>

<script>

    const data = <?php echo json_encode($data); ?>;

    document.querySelector('.news').style.gridTemplateColumns = 'auto auto auto';

    document.querySelectorAll('.article-title').forEach(title => {
        title.textContent = title.textContent.slice(0, 45) + (title.textContent.length > 45 ? '...' : '');
    });

    document.querySelectorAll('.article-description').forEach(desc => {
        desc.textContent = desc.textContent.slice(0, 100) + (desc.textContent.length > 100 ? '...' : '');
    });

    document.getElementById('reset').addEventListener('click', function() {
       document.getElementById("searchForm").submit();
    });

    document.getElementById('grid').addEventListener('click', function() {
        document.querySelector('.news').style.gridTemplateColumns = 'auto auto auto';

        const titles = document.querySelectorAll('.article-title');
        const descriptions = document.querySelectorAll('.article-description');

        data.forEach((article, index) => {
            if (titles[index]) {
                let title = article.title.length > 45 ? article.title.slice(0, 45) + '...' : article.title;
                titles[index].textContent = title;
            }

            if (descriptions[index]) {
                let desc = article.description.length > 100 ? article.description.slice(0, 100) + '...' : article.description;
                descriptions[index].textContent = desc;
            }
        });

        // Appliquer la hauteur et la largeur à chaque carte
        document.querySelectorAll('.article-card').forEach(card => {
            card.style.height = '400px';
            card.style.width = '350px';
        });

        // Appliquer le float:left à chaque image
        document.querySelectorAll('.article-image').forEach(img => {
            img.style.float = '';
        });

        document.querySelectorAll('.article-content').forEach(content => {
            content.style.textAlign = '';
        });
    });

    document.getElementById('column').addEventListener('click', function() {

        const data = <?php echo json_encode($data); ?>;

                // Appliquer la hauteur et la largeur à chaque carte
        document.querySelectorAll('.article-card').forEach(card => {
            card.style.height = '220px';
            card.style.width = '900px';
        });

        // Appliquer le float:left à chaque image
        document.querySelectorAll('.article-image').forEach(img => {
            img.style.float = 'left';
        });

        document.querySelectorAll('.article-content').forEach(content => {
            content.style.textAlign = 'left';
        });

        document.querySelector('.news').style.gridTemplateColumns = 'auto';

        const titles = document.querySelectorAll('.article-title');
        const descriptions = document.querySelectorAll('.article-description');

        data.forEach((article, index) => {
            if (titles[index]) {
                let title = article.title.length > 450 ? article.title.slice(0, 450) + '...' : article.title;
                titles[index].textContent = title;
            }

            if (descriptions[index]) {
                let desc = article.description.length > 1000 ? article.description.slice(0, 1000) + '...' : article.description;
                descriptions[index].textContent = desc;
            }
        });



    });

</script>

<style>

</style>