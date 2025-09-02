<?
if ($action=='login') {
    $email = isset($_POST['email']) ? htmlspecialchars($_POST['email']) : null;
    $email2 = isset($_POST['email2']) ? htmlspecialchars($_POST['email2']) : null;
    $password = isset($_POST['password']) ? htmlspecialchars($_POST['password']) : null;
    
    // $Acounts = $db->prepare('SELECT id, password FROM easybet_users WHERE email = :email AND off = 0');
    $Acounts = $db->prepare('SELECT * FROM easybet_users WHERE (email = :email OR pseudo = :email) AND off = 0');
    $Acounts->execute(array('email'=>$email));    
    
    if ($Acounts->rowCount()==1) {
        $_SESSION['activate'] = array();

        $Acount = $Acounts->fetch();
        $verify = password_verify($password, $Acount['password']);
        if ($verify==1) {
            $_SESSION['email'] = $Acount['email'];
            $_SESSION['auth'] = $Acount['auth'];
            Redirection($Url);
        }
        else $Retour = Message('Login ou mot de passe incorrect','error');
    }
    else $Retour = Message('Login ou mot de passe incorrect','error');
}
?>
<form method="POST" id="login">
    <h2><strong>Se connecter</strong></h2>
	<?=$Retour;?>
	<input type="hidden" name="action" value="login" />
	<input type="text" name="email" placeholder="Psuedo ou e-mail" />
	<input type="password" name="password" placeholder="Mot de passe" />
	<input type="submit" value="ok" />

    <p>
        <a href="<?=$Url;?>/lost">Mot de passe oublié ?</a>
    </p>
</form>
