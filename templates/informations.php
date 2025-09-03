<?
if ($data) {
    include 'templates/informations/'.$data.'.php';

}
else { include 'templates/informations/index.php';
    echo 'no data';
}
?>
