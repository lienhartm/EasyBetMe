<?
Title('Profile - '.$Site['nom']);

if ($niv3=='nl'):
    $nl = ($User['nl_off']==1) ? 0 : 1;
    $update = $db->prepare('UPDATE easybet_users SET nl_off=:nl WHERE email=:email');
    $update->execute(['nl'=>$nl, 'email'=>$User['email']]);
    Redirection($Url.'/profile/settings');
endif;

$old = isset($_POST['old']) ? htmlspecialchars($_POST['old']) : null;
$password = isset($_POST['password']) ? htmlspecialchars($_POST['password']) : null;
$password2 = isset($_POST['password2']) ? htmlspecialchars($_POST['password2']) : null;

$Utilisateurs = $db->prepare('SELECT password FROM easybet_users WHERE email = ?');
$Utilisateurs->execute([$User['email']]);
$Utilisateur = $Utilisateurs->fetch();

if ($old && $password && $password2) {
    $CheckPassword = password_verify($_POST['old'], $Utilisateur['password']);
    if ($CheckPassword) {
        if ($password == $password2) {
            $auth = Keygen(12,0);
            $pwd = password_hash($password, PASSWORD_DEFAULT);
            $update = $db->prepare('UPDATE easybet_users SET `password`=:pwd, auth=:auth WHERE email=:email');
            $update->execute(['pwd'=>$pwd, 'auth'=>$auth, 'email'=>$User['email']]);
            $Retour = Message('Votre mot de pass a été actualisé','valid');
        }
       else  $Retour = Message('Le nouveau mot de passe et la confirmation doivent être identiques !','error');
    }
    else {
        $Retour = Message('L\'Ancien mot de passe ne correspond pas','error');
    }
    
}
?>

<div class="content">
    <?
        include 'templates/'.$page.'/commun.php';
    ?>

    <div class="main">
        <h2><strong>Préférences</strong></h2>
        
        <h3><strong>Lettre d'information quotidienne</strong></h3>
        <div class="profile">
            <p>Recevoir les résultats quotidiens (1 mail par jour maximum)</p>
            <div class="on-off">
                <? if ($User['nl_off']==1): ?>
                <a href="<?=$Url.'/profile/settings/nl';?>">Oui</a>
                <a class="active" href="<?=$Url.'/profile/settings/nl';?>">Non</a>
                <? else: ?>
                <a class="active" href="<?=$Url.'/profile/settings/nl';?>">Oui</a>
                <a href="<?=$Url.'/profile/settings/nl';?>">Non</a>
                <? endif; ?>
            </div>
            <? if ($User['nl_off']==1): ?>
                <p>Vous ne recevez pas notre mail quotidien.</p>
            <? else: ?>
                <p>Vous recevez notre mail quotidien.</p>
            <? endif; ?>
        </div>

        <h3><strong>Mot de passe</strong></h3>
        <div class="profile">
            <?=$Retour;?>
            <form method="post">                
                <input type="password" name="old" placeholder="Votre ancien mot de passe" />
                <input type="password" name="password" placeholder="Votre nouveau mot de passe" />
                <input type="password" name="password2" placeholder="Confirmez votre nouveau mot de passe" />
                <input type="submit" value="OK" />
            </form>
        </div>
    </div>
</div>
        