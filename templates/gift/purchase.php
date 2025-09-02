<!-- Confirmation Modal (for enough points) -->
<div id="confirmModal" class="modal" >
    <div class="modal-content">
        <span class="close" onclick="closeModal()">×</span>
        <h2>Confirm Purchase</h2>
        <p>Are you sure you want to buy this <?php echo $Gift['nom']?> for <?php echo $Gift['prix']; ?> points?</p>
        <p>Dès votre confirmation un document au format PDF sera émis vous pourrez récupérez ce document directement dasn votre dossier de téléchargement.</p>
        <p>Ce document sera le seul gage de l'achat de ce cadeau garder le précieusement et imprimer pour le présenter,<p>
        <p>lors du retrait de votre cadeau avec ce bon de retrait, une présentation d'une pièce d'identité sous un délai de 30 jours.</p>
        <p>Passez ce délai sans réclamation ou annulation de votre part le cadeau sera remis en jeu mais vos points ne seront pas recrédités</p>
        <p>Enregistrer ce document et imprimez le pour le présenter le jour de retrait munis d'une pièce d'identité</p>
        <p>Merci d'avoir acheté ce cadeau sur EasyBet.me</p>
        <p>Attention addiction aux jeu !!</p>
        <form id="myForm" method="post" action="">
            <input type="hidden" name="iU" id="iU" />
            <input type="hidden" name="iG" id="iG" />
            <input type="submit" value="Valid" hidden/>
        </form>
        <button onclick="proceedWithPurchase()">Yes, Buy</button>
        <button onclick="closeModal()">Cancel</button>
    </div>
</div>

<script>

    // Fonction pour récupérer un paramètre d'URL
    function getUrlParameter(name) {
        var urlParams = new URLSearchParams(window.location.search);
        return urlParams.get(name);
    }

    // Récupérer les paramètres iU et iG de l'URL
    var iU = getUrlParameter('iU'); // Encodé en base64
    var iG = getUrlParameter('iG'); // Encodé en base64

    document.getElementById('iU').value=iU;
    document.getElementById('iG').value=iG;
    // Afficher les données déchiffrées

    function closeModal() {
        window.location.href="<?$Url?>/gift";
    }

    function proceedWithPurchase() {
        document.getElementById('myForm').submit();
        document.getElementById('confirModal').visibility = 'hidden';
    }

</script>

<?php

    require_once("fpdf/fpdf.php");

    //print_r($_POST);

    $iU = isset($_POST['iU']) ? $_POST['iU'] : null;
    $iG = isset($_POST['iG']) ? $_POST['iG'] : null;

    $secretKey = 'st';

    if ($iU && $iG) {
        // Décryptage des données
        $encryptedDataUrlIdUser = base64_decode($iU);
        $encryptedDataUrlIdGift = base64_decode($iG);    

        // Séparer l'IV du reste des données
        list($encryptedDataIdUser, $iv) = explode('::', $encryptedDataUrlIdUser, 2);
        list($encryptedDataIdGift, $iv) = explode('::', $encryptedDataUrlIdGift, 2);

        // Déchiffrer les données
        $idUser = openssl_decrypt($encryptedDataIdUser, 'aes-256-cbc', $secretKey, 0, $iv);
        $idGift = openssl_decrypt($encryptedDataIdGift, 'aes-256-cbc', $secretKey, 0, $iv);
    }

    if (isset($idUser) && isset($idGift)) {

        $Comptes = $db->prepare('SELECT * FROM easybet_users WHERE id=?');
        $Comptes->execute([$idUser]);
        $Compte = $Comptes->fetch();

        //print_r($Compte);
    
        $Cadeaux = $db->prepare('SELECT * FROM easybet_gifts WHERE id=?');
        $Cadeaux->execute([$idGift]);
        $Cadeau = $Cadeaux->fetch();

        //print_r($Cadeau);
        if($Cadeau && $Compte) {

            $sold = floatval($Compte['coins']) - floatval($Cadeau['prix']);
                
            // debiter le cadeau au solde de point
            $update = $db->prepare('UPDATE easybet_users SET points = :points WHERE id = :id');
            $update->execute(['points'=>$sold, 'id'=>$idUser]);
        
            // Préparer la requête pour supprimer le cadeau
            $stmt = $db->prepare('DELETE FROM easybet_gifts WHERE id = :id');
            $stmt->bindParam(':id', $idGift, PDO::PARAM_INT);
            $stmt->execute();


            $pdf = new FPDF();
            $pdf->AddPage();
            
            // Titre
            $pdf->SetFont('Arial', 'B', 16);  // Police en gras de taille 16
            $pdf->SetTextColor(0, 128, 0);  // Couleur verte (R=0, G=255, B=50)
            $pdf->SetFontSize(24);  // Taille de la police du titre
            $pdf->Cell(200, 10, 'easyBet.me', 0, 1, 'C');  // Ajouter le titre centré
            
            $pdf->Ln(10);  // Retour à la ligne
            $pdf->SetTextColor(0, 0, 0);  // Couleur du texte en blanc (R=255, G=255, B=255)
            $pdf->SetFontSize(12);  // Taille de police réduite pour le texte suivant
            $pdf->Cell(200, 10, 'Bon de Retrait', 0, 1, 'C');  // Ajouter le texte "Bon de Retrait" centré
            
            // Entête de document
            $pdf->SetFont('Arial', 'B', 8);  // Police normale de taille 12
            $pdf->Ln(15);  // Retour à la ligne
            $pdf->Cell(0, 5, "Nom: ".utf8_decode($Compte['pseudo']), 0, 1);  // Nom
            $pdf->Cell(0, 5, 'Email: '.utf8_decode($Compte['email']), 0, 1);  // Email
            $pdf->Ln(10);  // Retour à la ligne
            $pdf->SetFont('Arial', '', 8);
            $pdf->Cell(0, 5, 'Date: '.date('d/m/Y'), 0, 1);  // Date actuelle
            $pdf->Ln(10);  // Retour à la ligne
            
            // Corps du document
            $pdf->MultiCell(0, 5, 'Ce document est la preuve de l\'achat du cadeau: ');   
            $pdf->Ln(5);         
            $pdf->Cell(40);  // Décalage à gauche
            $pdf->Cell(0, 5, 'Identifiant: ' . utf8_decode($Cadeau['id']), 0, 1);  // Identifiant du cadeau
            $pdf->Cell(40);  // Décalage à gauche
            $pdf->Cell(0, 5, 'Cadeau: ' . utf8_decode($Cadeau['nom']), 0, 1);  // Nom du cadeau
            $pdf->Cell(40);  // Décalage à gauche
            $pdf->Cell(0, 5, 'Prix: ' . utf8_decode($Cadeau['prix']) . ' points', 0, 1);  // Prix du cadeau
            $pdf->Cell(40);  // Décalage à gauche
            $pdf->MultiCell(0, 5, 'Description: ' . utf8_decode($Cadeau['description']), 0, 1);  // Description du cadeau
            $pdf->Ln(5);  // Retour à la ligne
            $pdf->Cell(0, 5, utf8_decode("Veuillez conserver précieusement un exemplaire et imprimer un autre pour le retrait."),0,1);
            $pdf->Cell(0, 5, utf8_decode("Lors du retrait veuillez vous munir de ce document et de votre pièce d\'identité.Vous avez 30 jours pour récupérer votre cadeau."),0,1);
            $pdf->Cell(0, 5, utf8_decode("Passé ce délai sans réclamation, il sera remis en jeu, mais vos points ne seront pas recrédités."),0,1);

            // Pied de page
            $pdf->Ln(10);  // Retour à la ligne
            $pdf->Cell(100);
            $pdf->Cell(0, 5, utf8_decode('Merci de votre fidélité.'),0,0);
            $pdf->Ln(10);  // Retour à la ligne
            $pdf->Cell(100);
            $pdf->SetTextColor(0, 0, 0);  // Noir
            $pdf->SetFont('Arial', '', 8);  // Police normale de taille 12
            $pdf->Cell(0, 5, utf8_decode('L\'équipe '), 0, 0);  // Signature "L'équipe EasyBet"
            $pdf->SetFont('Arial', 'B', 8);  // Police normale de taille 12
            $pdf->SettextColor(0,128,0);
            $pdf->Cell(-78);
            $pdf->Cell(0,5, utf8_decode($Site['nom']), 0, 1);          
            // Output the PDF to the browser or save it
            $pdfPath = '/retrait/ticket_retrait.pdf';  // Define a path to save the file
            //$pdf->Output('F', $pdfPath);  // Save the file to the server
            $pdf->Output('F', __DIR__ . $pdfPath);
            // Output the PDF to the browser or save it
            // If you want to force the download
            //$pdf->Output('D', 'ticket_retrait.pdf');
        }
    }


    if (isset($pdfPath)) {
    
        $expediteur = 'contact@easybet.me';
        $email = $Compte["email"].', '.$expediteur;
        $eol = "\r\n";  // End of line for email headers
                        
            $headers = 'From: '.$expediteur.$eol;
            $headers.= 'Reply-To:'.$expediteur.$eol;
            $headers.= 'MIME-Version: 1.0'.$eol;
            $headers.= 'Content-Type: text/html; charset=utf-8'.$eol;

            if (file_exists(__DIR__ . '/retrait/ticket_retrait.pdf')) {                
                $file = __DIR__.'/retrait/ticket_retrait.pdf';
                $fileContent = file_get_contents($file);
                $fileName = basename($file);
                $fileContent = chunk_split(base64_encode($fileContent));
            } else {
                echo "Error: PDF file not found.";
            }
                                
            $objet   = 'Achat d\'un cadeau '.$Site['nom'];
            /*
            $msg = '<p>Bonjour, '.$Compte['pseudo'].'</p><br />';
            $msg .= '<p>Voici votre ticket de retrait pour le cadeau que vous avez commandé en pièce jointe à ce mail.</p>';
            $msg .= '<p>Lors du retrait veuillez vous présenter muni du bon et de votre pièce d\'indentité</p><br />';
            $msg .= '<p>Merci de votre fidélité!</p>';
            $msg .= '<br /><br />';
            $msg.= '<p>A très vite !</p>';
            $msg.= '<p>L\'équipe de '.$Site['nom'].'.</p>';
            */

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
                            <p>Bonjour, '.$Compte['pseudo'].'</p>
                            <br />
                            <p>Félicitation, pour l\'achat de ce cadeaux sur le site <span style="font-weight:bold;color:green;">easyBet.me</span>.</p>
                            <br />
                            <p>Achat effectué :</p>
                            <blockquote>
                                <p>Identifiant: '.$Cadeau['id'].'</p>
                                <p>Nom: '.$Cadeau['nom'].'</p>
                                <p>Prix: '.$Cadeau['prix'].' points</p>
                                <p>Description: '.$Cadeau['description'].'</p>
                            </blockquote>
                            <br />
                            <p>Votre bon de retrait ce trouve en pièce jointe à ce mail.</p>
                            <p>Lors du retrait veuillez vous présenter muni du bon et de votre pièce d\'indentité.</p>
                            <br />
                            <p style="margin-left:450px;">Merci de votre fidélité!</p>
                            <p style="margin-left:450px;">A très vite !</p>
                            <p style="margin-left:450px;">L\'équipe de <span style="font-weight:bold;color:green;">&#xA0;&#xA0;easyBet.me&#xA0;&#xA0;</span>.</p>
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
            $message .= "Content-Type: application/pdf; name=\"$fileName\"\r\n";
            $message .= "Content-Disposition: attachment; filename=\"$fileName\"\r\n";
            $message .= "Content-Transfer-Encoding: base64\r\n\r\n";
            $message .= $fileContent . "\r\n\r\n";
            $message .= "--$boundary--";

            if(mail($email, $objet, $message, $headers)) {
                Redirection($Url."/gift");
            }
        
    }    


?>

<style>

/* Modal Styles */
    .modal {
        position: fixed; /* Stay in place */
        z-index: 1; /* Sit on top */
        left: 0;
        top: 0;
        width: 100%; /* Full width */
        height: 100%; /* Full height */
        overflow: auto; /* Enable scroll if needed */
        background-color: rgba(0, 0, 0, 0.4); /* Black w/ opacity */
    }

    .modal-content {
        background-color: #fefefe;
        margin: 15% auto;
        padding: 20px;
        border: 1px solid #888;
        width: 80%;
        max-width: 400px;
    }

    .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .close:hover,
    .close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }

    button {
        padding: 10px 20px;
        margin: 5px;
        cursor: pointer;
    }

</style>
