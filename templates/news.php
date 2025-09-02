<?
if ($data) {
    echo 'ok';
    include 'templates/news/'.$data.'.php';

}
else { include 'templates/news/index.php';
    echo 'no data';
}
?>