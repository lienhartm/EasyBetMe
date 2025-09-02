<?
$id = substr($data,15);
$auth = substr($data,0,15);

$Acounts = $db->prepare('SELECT * FROM easybet_users WHERE id = :id AND auth = :auth AND off = 1');
$Acounts->execute(array('id'=>$id,'auth'=>$auth));

if ($Acounts->rowCount()==1) {
    $auth = Keygen(15,0);

    $activate = $db->prepare('UPDATE easybet_users SET off = 0, auth=:auth WHERE id = :id');
    $activate->execute(array('auth'=>$auth, 'id'=>$id));

    $_SESSION['activate'] = 1;

    Redirection($Url.'/login');
}
else Redirection($Url.'/login');
?>