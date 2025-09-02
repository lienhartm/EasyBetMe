<?
Title('Profile - '.$Site['nom']);

$Retour = 'Changer de mot de passe';

$old = isset($_POST['old']) ? htmlspecialchars($_POST['old']) : null;
$password = isset($_POST['password']) ? htmlspecialchars($_POST['password']) : null;
$password2 = isset($_POST['password2']) ? htmlspecialchars($_POST['password2']) : null;

$Utilisateurs = $db->prepare('SELECT password FROM users WHERE email = ? AND id_site = ?');
$Utilisateurs->execute([$User['email'], $id_site]);
$Utilisateur = $Utilisateurs->fetch();

if ($old && $password && $password2) {
    $CheckPassword = password_verify($_POST['old'], $Utilisateur['password']);
    if ($CheckPassword) {
        if ($password == $password2) {
            $auth = Keygen(12,0);
            $pwd = password_hash($password, PASSWORD_DEFAULT);
            $update = $db->prepare('UPDATE users SET `password` = "'.$pwd.'", auth = "'.$auth.'" WHERE email = "'.$User['email'].'" AND id_site = '.$id_site);
            $update->execute();
            $Retour = 'Votre mot de pass a été actualisé';
        }
       else  $Retour = 'Le nouveau mot de passe et la confirmation doivent être identiques !';
    }
    else {
        $Retour = 'L\'Ancien mot de passe ne correspond pas';
    }
    
}
?>

<div class="content">
    <?
        include 'templates/'.$page.'/commun.php';
    ?>

    <div class="main">
        <h2><strong>Modifier votre mot de passe</strong></h2>

        <div class="profile">
            <form method="post">                
                <input type="password" name="old" placeholder="Votre ancien mot de passe" />
                <input type="password" name="password" placeholder="Votre nouveau mot de passe" />
                <input type="password" name="password2" placeholder="Confirmez votre nouveau mot de passe" />
                <input type="submit" value="OK" />
            </form>
        </div>
    </div>
</div>
        