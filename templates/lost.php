<?
$action = isset($_POST['action']) ? htmlspecialchars($_POST['action']) : null;

if ($action=='lost') {
    $email = isset($_POST['email']) ? htmlspecialchars($_POST['email']) : null;

    $Comptes = $db->prepare('SELECT * FROM easybet_users WHERE email=? AND off=0');
    $Comptes->execute([$email]);
    $nbComptes = $Comptes->rowCount();
    
    if ($nbComptes==1):
        $auth = Keygen(15,0);

        $update = $db->prepare('UPDATE easybet_users SET auth = :auth WHERE email = :email');
        $update->execute(['auth'=>$auth, 'email'=>$email]);

        $Compte = $Comptes->fetch();
        $id = $Compte['id'];

        $expediteur = 'contact@easybet.me';
                    
        $headers = 'From: '.$expediteur.$eol;
        $headers.= 'Reply-To:'.$expediteur.$eol;
        $headers.= 'MIME-Version: 1.0'.$eol;
        $headers.= 'Content-Type: text/html; charset=utf-8'.$eol;
                            
        $objet   = 'Réinitialisez votre mot de passe sur '.$Site['nom'];

        $msg = '<p>Bonjour,</p>';
        $msg.= '<p>Votre avez demandé à réinitialiser votre mot de passe sur '.$Site['nom'].'.</p>';
        $msg.= '<p>Vous pourrez définir un nouveaux mot de passe en cliquant sur le lien ci-dessous:</p>';
        $msg.= '<p><a href="'.$Url.'/reset/'.$auth.$id.'">'.$Url.'/reset/'.$auth.$id.'</a></p>';
        $msg.= '<p>A très vite !</p>';
        $msg.= '<p>L\'équipe de '.$Site['nom'].'.</p>';

        mail($email, $objet, $msg, $headers);
    endif;
    
    $Retour = Message('Les instructions pour récupérer votre mot de passe ont été envoyées par mail.','valid');
}
?>
<form method="POST" id="login">
    <h2><strong>Réinitialisez votre mot de passe:</strong></h2>
    <div class="form">
        <?=$Retour;?>
        <input type="hidden" name="action" value="lost" />
        <input type="text" name="email" placeholder="Votre e-mail" />
        <input type="submit" value="OK" />
    </div>
</form>