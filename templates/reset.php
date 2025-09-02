<?
$action = isset($_POST['action']) ? htmlspecialchars($_POST['action']) : null;

$id = substr($data,15);
$auth = substr($data,0,15);

$Acounts = $db->prepare('SELECT * FROM easybet_users WHERE id = ? AND auth = ? AND off=0');
$Acounts->execute([$id,$auth]);
$nbAcounts = $Acounts->rowCount();

if ($nbAcounts==1):
    if ($action=='reset'):
        $password = isset($_POST['password']) ? htmlspecialchars($_POST['password']) : null;
        $password2 = isset($_POST['password2']) ? htmlspecialchars($_POST['password2']) : null;

        if ($password!=$password2):
            $Retour = Message('Les deux mots de passe doivent être identiques','error');
        else: 
            $auth2 = Keygen(15,0);
            $pwd = password_hash($password, PASSWORD_DEFAULT);

            $update = $db->prepare('UPDATE easybet_users SET password=:password, auth=:auth WHERE id=:id');
            if ($update->execute(['password'=>$pwd, 'auth'=>$auth2, 'id'=>$id])):
                $Retour = Message('Le mot de passe a été modifié.<br /><a href="'.$Url.'/login">Ok</a>','valid');
            else:
                $Retour = Message('Une erreur s\'est produite. Veuillez réessayer','error');
            endif;
    endif;

endif;

    ?>
        <form method="POST" id="login">
            <h2><strong>Modifiez votre mot de passe:</strong></h2>
            <div class="form">
                <?=$Retour;?>
                <input type="hidden" name="action" value="reset" />
                <input type="password" name="password" placeholder="Nouveau mot de passe" />
                <input type="password" name="password2" placeholder="Confirmer le mot de passe" />
                <input type="submit" value="OK" />
            </div>
        </form>
    <?
else:
Redirection($Url);
endif;
?>