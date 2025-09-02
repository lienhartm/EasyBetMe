<?
$id = substr($data,15);
$auth = substr($data,0,15);

$Acounts = $db->prepare('SELECT * FROM easybet_users WHERE id=:id AND auth=:auth AND off=0');
$Acounts->execute(['id'=>$id, 'auth'=>$auth]);

$nbAccounts = $Acounts->rowCount();

if ($nbAccounts == 1) {
    $auth2 = Keygen(15,0);

    $activate = $db->prepare('UPDATE easybet_users SET nl_off=1, auth=:auth WHERE id = :id');
    $activate->execute(array('auth'=>$auth2, 'id'=>$id));

    $_SESSION['message'] = Message('Vous ne recevrez plus de message de notre part','valid');

    Redirection($Url);
}
else Redirection($Url);
?>