<?
if ($_SERVER['HTTP_REFERER']==$Url.'/paiement') {
    $credits = $data;
    $prix = $Formules[$data];
    $date = date('Y-n-d H:i:s',time());

    $insert_paiement = $db->prepare('INSERT INTO paiement 
        (id_site, payment_id, payment_amount, payment_date, payment_email) 
        VALUES 
        (:id_site, :payement_id, :payment_amount, :payment_date, :payment_email)');
    $insert_paiement->execute(['id_site'=>$id_site, 'payement_id'=>$User['id'], 'payment_amount'=>$prix, 'payment_date'=>$date, 'payment_email'=>$User['email']]);

    $update = $db->prepare('UPDATE easybet_users SET credits = credits + :nbc WHERE id = :id_user AND email = :email AND auth = :auth');
    if ($update->execute(['nbc'=>$credits, 'id_user'=>$User['id'], 'email'=>$User['email'], 'auth'=>$User['auth']]));
    
    $_SESSION['message'] = Message('Vos crédits ont été ajoutés.<br />Merci pour votre achat','valid');
}
Redirection ($Url);
?>

