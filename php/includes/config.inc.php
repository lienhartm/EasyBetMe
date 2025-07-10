<?php

class BD {

	private $bdd;
	
	public function __construct() {
	        try {
			$this->bdd = new PDO('mysql:host=db;dbname=easybet;charset=utf8', 'monwebpro', 'toor');
		        $this->bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        	} catch (PDOException $e) {
        		echo 'Connexion échouée : ' . $e->getMessage();
        	}
	}
	
	function getBD() {
		return $this->bdd;
	}
	
	public function executeRequest($sql, $params = NULL) {
		if ($params == NULL) {
			$resultat = $this->bdd->query($sql);
		} else {
			$resultat = $this->bdd->prepare($sql);
			$resultat->execute($params);
		}
		
		return $resultat;
	}
}

?>



