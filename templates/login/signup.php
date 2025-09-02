<?
define('RECAPTCHA_SITE_KEY','6Lfsy20pAAAAAJ0PvRi1TSkpYZYSerlDqNxTvZfT');
define('RECAPTCHA_SECRET_KEY','6Lfsy20pAAAAADfFly4GB90SNLNgc2ISKhT3xJRK');

if (check_token($_POST['g-recaptcha-response'], RECAPTCHA_SECRET_KEY)) {
    $pseudo = isset($_POST['pseudo']) ? htmlspecialchars($_POST['pseudo']) : null;
    $email = isset($_POST['email']) ? htmlspecialchars($_POST['email']) : null;
    $email2 = isset($_POST['email2']) ? htmlspecialchars($_POST['email2']) : null;
    $password = isset($_POST['password']) ? htmlspecialchars($_POST['password']) : null;
    $password2 = isset($_POST['password2']) ? htmlspecialchars($_POST['password2']) : null;
    if ($email !='' && $password !='') {
        $errors = 0;
        if ($email != $email2) $errors++;
        if ($password != $password2) $errors++;

        if ($errors>0) $Retour2 = Message('Les adresse email et mots de passe doivent être identiques','error');
        else {
            $doublons = $db->prepare('SELECT * FROM easybet_users WHERE email = ? OR pseudo = ?');
            $doublons->execute([$email, $pseudo]);
            $nbDoublons = $doublons->rowCount();

            if ($nbDoublons==0) {
                $auth = Keygen(15,0);
                $pwd = password_hash($password, PASSWORD_DEFAULT);
                $credits = 30;

                $sql = 'INSERT INTO easybet_users 
                    (id, date_inscription, pseudo, email, `password`, `off`, auth, credits) VALUES 
                    ("", "'.date('Y-n-d H:i:s',time()).'", "'.$pseudo.'",  "'.$email.'", "'.$pwd.'", 1, "'.$auth.'", '.$credits.')';

                $insert = $db->prepare($sql);
                if ($insert->execute()) {
                    $id = $db->lastInsertID();

                    $expediteur = 'contact@easybet.me';
                    
                    $headers = 'From: '.$expediteur.$eol;
                    $headers.= 'Reply-To:'.$expediteur.$eol;
                    $headers.= 'MIME-Version: 1.0'.$eol;
                    $headers.= 'Content-Type: text/html; charset=utf-8'.$eol;
                                        
                    $objet   = 'Bienvenue sur '.$Site['nom'];
    
                    $msg = '<p>Bonjour,</p>';
                    $msg.= '<p>Votre compte a bien été créé.</p>';
                    $msg.= '<p>Vous devez à présent l\'activer en cliquant sur le lien ci-dessous.</p>';
                    $msg.= '<p><a href="'.$Url.'/activate/'.$auth.$id.'">'.$Url.'/activate/'.$auth.$id.'</a></p>';
                    $msg.= '<p>A très vite !</p>';
                    $msg.= '<p>L\'équipe de '.$Site['nom'].'.</p>';
        
                    mail($email, $objet, $msg, $headers);

                    $Retour2 = Message('Votre compte a été créé.<br />Un email vous a été envoyé pour activer votre compte. Pensez à vérifier les spams! A très vite !','valid');
                }
            }
            else $Retour2 = Message('Un utilsateur est déjà enregistré dans nos système avec cet email ou ce pseudo','error');
        }
    }
    else $Retour2 = Message('Vous devez saisir un email et un mot de passe','error');
}
?>
<form method="POST" id="signup">
    <h2><strong>Créer un compte</strong></h2>
	<?=$Retour2;?>
	<input type="hidden" name="action" value="signup" />
	<input type="pseudo" name="pseudo" placeholder="Choisissez un pseudo" />
	<input type="email" name="email" placeholder="Votre email" />
	<input type="email" name="email2" placeholder="Confirmez votre email" />
	<input type="password" name="password" placeholder="Mot de passe" />
	<input type="password" name="password2" placeholder="Confirmez votre mot de passe" />
    <button class="g-recaptcha" 
        data-sitekey="<?php echo RECAPTCHA_SITE_KEY; ?>" 
        data-callback='onSubmit' 
        data-size='invisible'
        data-action='submit'>ok</button>
</form>

<script src="https://www.google.com/recaptcha/api.js"></script>

<script>
    function onSubmit() {
        document.getElementById("signup").submit();
    }
</script>
