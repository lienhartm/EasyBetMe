<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $objet = isset($_POST['objet']) ? htmlspecialchars($_POST['objet']) : null;
    $corps = isset($_POST['message']) ? htmlspecialchars($_POST['message']) : null;

    $date = date('Y-n-d',time());

    $Players = $db->prepare('SELECT * FROM easybet_users WHERE last_nl != ? AND off=0');
    $Players->execute([$date]);


    while ($Player = $Players->fetch()) {

        $expediteur = 'EasyBet.me <contact@easybet.me>';
        $sujet = 'La newsletter d\''.$Site['nom'];	

        $headers = 'From:'.$expediteur.$eol;
        $headers.= 'Reply-To:'.$expediteur.$eol;
        $headers.= 'MIME-Version: 1.0'.$eol;
        $headers.= 'Content-Type: text/html; charset=utf-8'.$eol;

        $message = '
            <html>
                <head>
                    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                    <title></title>
                </head>
                <body style="background-image: url('.$Url.'/images/football.jpg);">
                    <br />
                    <center>
                        <img src="'.$Url.'/images/logo-easybet.png" />
                    </center>
                    <br />
                    <blockquote style="font-size: 1.5em; margin: 250px:">
                        <h1>'.$objet.'</h1>
                        <br />
                        <pre style="font-size:14px;">'.$corps.'</pre>
                        <br />
                    </blockquote>
                    <br />
                </body>
                <footer>
                    <br />
                    <center>
                        <img src="'.$Url.'/images/logo-easybet.png" />
                    </center>
                    <br />
                    <p style="text-align: center;">A tout de suite sur <a href="'.$Url.'">'.$Site['nom'].'</a> pour votre pari du jour</p>
                    <p style="font-size: 0.9em; text-align: center;">
                        <a href="'.$Url.'/unsuscribe/'.$User['auth'].$User['id'].'">Se désabonner</a>
                    </p>
                    <br />
                </footer>
            </html>
            ';

        if (mail($Player['email'], $sujet, $message, $headers)) {
            $update = $db->prepare('UPDATE easybet_users SET last_nl = "'.$date.'" WHERE id = '.$Player['id']);
            $update -> execute();
        }
    }

    //mail('', $sujet, $message, $headers);

}
?>

<div class="newsletter">
    <h2>Newsletter</h2>
    <div class="show">
       <form method="post" enctype="multipart/form-data">
            <input type="text" name="objet" placeholder="objet" />
            <textarea style="font-size:12px;" name="message" placeholder="message" ></textarea>
            <input type="submit" value="Envoyer" />
        </form>
    </div>

    <a href="<?=$Url;?>/admin#">Retour</a>

</div>

<style>
    a {
        text-decoration: none;
        color: #333;
    }
    a:hover {
        text-decoration: none;
        background-color: #ccc;
    }
    .newsletter a {
        text-align: center;
        background-color: #e9e9ed;
        color: #000;
        width: 100%;
        height: 40px;
        line-height: 40px;
        display: block;
        padding: 0 10px;
        margin: 5px 0;
        border-radius: 20px;
        border: solid 1px rgba(0,0,0,0.3);
    }
    div.admin {display:block;}
    .newsletter {
        width: 100%;
        max-width: 600px;
        margin: 0 auto;
        padding: 20px;
        background-color: #f9f9f9;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }
    h2 {
        text-align: center;
        font-size: 2em;
        margin-bottom: 20px;
    }
    .show {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
    }
    .show form {
        display: flex;
        flex-direction: column;
        width: 300px;
    }
    .show form input[type="text"],
    .show form textarea {
        width: 100%;
        padding: 10px;
        margin-bottom: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

</style>