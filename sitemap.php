<?
$id_site = 9;

$db_server = 'db5001933572.hosting-data.io';
$db_name = 'dbs1582075';
$db_login = 'dbu1385152';
$db_password = 'IiBr8ICK0x!?xHd2PQ1CT4B8';

try {
    $db = new PDO('mysql:host='.$db_server.';dbname='.$db_name.';charset=utf8', $db_login, $db_password);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (PDOException $e) {
    Message('Falta connexão','error');
    exit;
}

$Sites = $db->prepare('SELECT * FROM sites WHERE id=?');
$Sites->execute([$id_site]);
$Site = $Sites->fetch();

$Nom = $Site['nom'];
$Url = $Site['url'];

$ln = "\n";
$tab = "\t";

$xml = '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'."\n";

$xml.=$tab.'<url>'.$ln;
    $xml.=$tab.$tab.'<loc>'.$Url.'</loc>'.$ln;
    $xml.=$tab.$tab.'<lastmod>'.date('Y-n-d',time()).'</lastmod>'.$ln;
    $xml.=$tab.$tab.'<priority>1.0</priority>'.$ln;
$xml.=$tab.'</url>'.$ln;
$xml.=$tab.'<url>'.$ln;
    $xml.=$tab.$tab.'<loc>'.$Url.'/login</loc>'.$ln;
    $xml.=$tab.$tab.'<lastmod>'.date('Y-n-d',time()).'</lastmod>'.$ln;
    $xml.=$tab.$tab.'<priority>1.0</priority>'.$ln;
$xml.=$tab.'</url>'.$ln;
$xml.=$tab.'<url>'.$ln;
    $xml.=$tab.$tab.'<loc>'.$Url.'/aide</loc>'.$ln;
    $xml.=$tab.$tab.'<lastmod>'.date('Y-n-d',time()).'</lastmod>'.$ln;
    $xml.=$tab.$tab.'<priority>0.7</priority>'.$ln;
$xml.=$tab.'</url>'.$ln;

$xml.='</urlset>';

$file = 'sitemap.xml';
$fileopen=(fopen("$file",'w+'));
fwrite($fileopen,$xml);
fclose($fileopen);
?>
