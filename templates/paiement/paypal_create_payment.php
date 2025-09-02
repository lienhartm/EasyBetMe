<?php
require_once "../includes/config.inc.php"; // On est déjà dans le dossier "php" à la racine de notre site, on peut donc directement inclure "config.php" qui se trouve dans ce même dossier
require_once "$Url/templates/paiement/PayPalPayment.php"; // On inclue les fichiers relativement à la position du fichier actuel, qui est déjà dans le dossier "php"

$success = 0;
$msg = "Une erreur est survenue, merci de bien vouloir réessayer ultérieurement...";
$paypal_response = [];

$payer->setSandboxMode(1); // On active le mode Sandbox
$payer->setClientID("AYauLWXsPAwve2-OwkXiAG2TdmiqyWZfMrB36lhrBTgXmG29x7B_ZQPvaNCEU39d1thdJA-zl6AWUdVh"); // On indique sont Client ID
$payer->setSecret("ECX7EweUwOrNRknOiKTrFlRiGSZenjRmHIhnMHXYMyRNcdthBTIGUpf-PMPv7pmx40ZzSqUi3Ea2bdZ1"); // On indique son Secret

$payment_data = [
    "intent" => "sale",
    "redirect_urls" => [
       "return_url" => "$Url",
       "cancel_url" => "$Url"
    ],
    "payer" => [
       "payment_method" => "paypal"
    ],
    "transactions" => [
       [
          "amount" => [
             "total" => "9.99", // Prix total de la transaction, ici le prix de notre item
             "currency" => "EUR" // USD, CAD, etc.
          ],
          "item_list" => [
             "items" => [
                [
                   "sku" => "1PK5Z9", // Un identifiant quelconque (code / référence) que vous pouvez attribuer au produit que vous vendez
                   "quantity" => "1",
                   "name" => "Un produit quelconque",
                   "price" => "9.99",
                   "currency" => "EUR"
                ]
             ]
          ],
          "description" => "Description du paiement..."
       ]
    ]
 ];

$paypal_response = $payer->createPayment($payment_data);
$paypal_response = json_decode($paypal_response);

if (!empty($paypal_response->id)) {
    $insert = $bdd->prepare("INSERT INTO paiements (id_site, payment_id, payment_status, payment_amount, payment_currency, payment_date, payer_email, payer_paypal_id, payer_first_name, payer_last_name) VALUES (:id_site, :payment_id, :payment_status, :payment_amount, :payment_currency, NOW(), '', '', '', '')");
    $insert_ok = $insert->execute(array(
        "id_site" => $id_site,
        "payment_id" => $paypal_response->id,
        "payment_status" => $paypal_response->state,
        "payment_amount" => $paypal_response->transactions[0]->amount->total,
        "payment_currency" => $paypal_response->transactions[0]->amount->currency,
     ));

     if ($insert_ok) {
        $success = 1;
        $msg = "";
    } 
}
else {
    $msg = "Une erreur est survenue durant la communication avec les serveurs de PayPal. Merci de bien vouloir réessayer ultérieurement.";
}

echo json_encode(["success" => $success, "msg" => $msg, "paypal_response" => $paypal_response]);