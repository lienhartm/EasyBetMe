<?php
function Message($Message,$class) {
    switch($class){
        case 'error': $icon = '&#xea0d;'; break;
        case 'valid': $icon = '&#xea10;'; break;
        case 'info': $icon = '&#xea0c;'; break;
        default: $icon = null; break;
    }
    return '<div class="message '.$class.'"><p><span class="icon">'.$icon.'</span>'.$Message.'</p></div>';
}
function Redirection($Lien) {
	echo '<script>';
	echo 'document.location.href="'.$Lien.'";';
	echo '</script>';
}
function rdate($date) {
	$Jours = array(1=>'Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi','Dimanche');
	$Mois = array(1=>'janvier','février','mars','avril','mai','juin','juillet','aout','septembre','octobre','novembre','décembre');

	$timestamp = strtotime($date);
	// return $timestamp;
	
	$phrase = $Jours[date('w',$timestamp)].' '.date('d',$timestamp).' '.$Mois[date('n',$timestamp)].' '.date('Y',$timestamp);
	$phrase.= '&nbsp;-&nbsp;';
	$phrase.= date('H',$timestamp).':'.date('i',$timestamp);
	
	return $phrase;
}
function Keygen(int $nombre_caracteres, bool $caractere_speciaux) {
    $key = null;
    if ($caractere_speciaux==1) {
        $caracteres = array(
            'A','B','C','D','E','F','G','H','J','K','L','M','N','P','Q','R','S','T','U','V','X','Y','Z',
            'a','b','c','d','e','f','g','h','i','j','j','m','n','p','q','r','s','t','u','v','x','y','z',
            '1','2','3','4','5','6','7','8','9',
            '&','@','+','$','?','!','$'
        );
    }
    else {
        $caracteres = array(
            'A','B','C','D','E','F','G','H','J','K','L','M','N','P','Q','R','S','T','U','V','X','Y','Z',
            'a','b','c','d','e','f','g','h','i','j','j','m','n','p','q','r','s','t','u','v','x','y','z',
            '1','2','3','4','5','6','7','8','9',
        );
    }
    
    for ($i=0; $i<$nombre_caracteres; $i++) {
        $r = rand(0,count($caracteres)-1);
        $key.= $caracteres[$r];
    }
    
    return $key;
}
function Title($title) {
	echo '<script>$(document).prop("title", "'.$title.'")</script>';
}
function check_token($token,$secret_key) {
	$verif_url  = "https://www.google.com/recaptcha/api/siteverify?secret=$secret_key&response=$token";
	$curl = curl_init($verif_url);
	curl_setopt($curl, CURLOPT_HEADER, false);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	$verif_response = curl_exec($curl);
	if ( empty($verif_response) ) return false;
	else { 
		$json = json_decode($verif_response);
		return $json->success;
	}
}
?>