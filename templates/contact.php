<h3>Demande de contact</h3>
<div class="contact">
    <p>Merci de nous faire part de vos réclamations, remarques, critique ou améliorations possible.<br /> Notre équipe de webmaster prendra le temps d'étudier votre courriel.</p>
    <p class="sign">L'équipe&nbsp;<strong><?=ucfirst($Site['nom']);?></strong>&nbsp;</p>
</div>

<hr class="contact">

<div  class="contact">
    <form method="post" action="" >
        <label for="email">Votre addresse mail:</label>
        <br />
        <input type="email" name="email" value="" placeholder="email" >
        <br />
        <label for="object">Objet du message:</label>
        <br />
        <input type="texte" name="object" value="" placeholder="object" >
        <br />
        <label for="texte">Corps du courriel:</label>
        <br />
        <textarea name="texte" value=""  > ...</textarea>
        <br />
        <br />
        <div class="contact">
            <input type="submit" name="mail" value="Envoyer" >
        </div>
    </form>
</div>

<style>
h3 {text-align:center;font-weight:bold;}
.contact {
    display:flex;
    justify-content:center;
    align-items:center;
    flex-direction:column;
    margin:50px;
}
hr.contact {
    margin:auto;
    width:100px;
}
.sign {
    margin-left:200px;
}
input[type='submit'] {
	width: 100px;
	height: 40px;
	line-height: 40px;
    display: block;
    padding: 0 10px;
    margin: 5px 0;
    border-radius: 20px;
    border: solid 1px rgba(0,0,0,0.3);
}
label {
    font-weight:bold;
    margin:10px;
}
</style>

<?php

$email = isset($_POST['email']) ? $_POST['email'] : '';
$object = isset($_POST['object']) ? $_POST['object'] : '';
$texte = isset($_POST['texte']) ? $_POST['texte'] : '';

if ($email && $object && $texte) {
    
    $expediteur = 'contact@easybet.me';
    $email = $Compte["email"];//.', '.$expediteur;
    $eol = "\r\n";  // End of line for email headers
                    
        $headers = 'From: '.$email.$eol;
        $headers.= 'Reply-To:'.$email.$eol;
        $headers.= 'MIME-Version: 1.0'.$eol;
        $headers.= 'Content-Type: text/html; charset=utf-8'.$eol;

        $objet = 'Demande de contact';

        $msg = '
            <!DOCTYPE html>
            <html>
                <head>
                    <meta name="viewport" content="width=device-width, initial-scale=1">
                    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
                </head>
                <body>
                    <h1 style="font-size:48px;font-weight:bold;color:green;text-align:center;">
                        <i class="fas fa-futbol" style="font-size:48px;color:black;"></i>
                        &#xA0;&#xA0;easyBet.me&#xA0;&#xA0;
                        <i class="fas fa-futbol" style="font-size:48px;color:black;"></i>
                    </h1>
                    <br />
                    <div style="padding:50px 150px 0 150px;">
                        <h2>Message:</h2>
                        <h3>Expéditeur:</h3>
                        <p>'.$email.'</p>
                        <h3>Objet du message:</h3>
                        <p>'.$object.'</p>
                        <h3>Corps du message:</h3>
                        <div>'.$texte.'</div>
                    </div>
                    <br />
                    <br />
                    <br />
                    <br />
                    <h6 style="text-align:center;color:gray;">
                        Contactez-nous à l\'addresse suivante '.$expediteur.'
                        <br />
                        <br />
                        <span style="font-weight:bold;color:green;">
                            <i class="fas fa-futbol" style="font-size:12px;color:black;"></i>
                                &#xA0;&#xA0;easyBet.me&#xA0;&#xA0;
                            <i class="fas fa-futbol" style="font-size:12px;color:black;"></i>
                        </span>
                    </h6>

                </body>
                </html>
        ';

        // Envoi de l'email avec pièce jointe
        $boundary = uniqid('np');
        $headers = "From: ".$expediteur."\r\n";
        $headers .= "Reply-To: ".$expediteur."\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: multipart/mixed; boundary=\"$boundary\"\r\n";
        $message = "--$boundary\r\n";
        $message .= "Content-Type: text/html; charset=UTF-8\r\n\r\n";
        $message .= $msg ."\r\n\r\n";
        $message .= "--$boundary\r\n";
        $message .= "--$boundary--";

    if(mail($email, $objet, $message, $headers)) {
        Redirection($Url);
    }
}

?>