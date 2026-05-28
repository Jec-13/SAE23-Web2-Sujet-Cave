<?php

function get_bdd_comptes(){
	$retour = false;
		$madb = new PDO('sqlite:../BDD/comptes.sqlite');
		$requete = "SELECT u.EMAIL, u.PASS, u.STATUT
		            FROM utilisateurs u";
		$resultat = $madb->query($requete);
		$tableau = $resultat->fetchAll(PDO::FETCH_ASSOC);
		if (sizeof($tableau) != 0) {
			$retour = $tableau;
		}
		return $retour;
};

function get_liste_vins(){
	$retour = false;
		$madb = new PDO('sqlite:../BDD/cave.sqlite');
		$requete = "SELECT vins.CRU, vins.COULEUR, vins.ORIGINE, negociants.NOM, negociants.REGION
		            FROM cave
					JOIN negociants ON negociants.noN=cave.noN
					JOIN vins on vins.noV=cave.noV";
		$resultat = $madb->query($requete);
		$tableau = $resultat->fetchAll(PDO::FETCH_ASSOC);
		if (sizeof($tableau) != 0) {
			$retour = $tableau;
		}
		return $retour;
};

function is_admin($mail){
	$liste_util=get_bdd_comptes();
	$retour=false;
	foreach ($liste_util as $key => $val){
		if ($mail == $val["EMAIL"] && $val["STATUT"] == "admin"){
			$retour = true;
		}
    }
	return $retour;
}

function test_connexion($mail, $pass){
	$liste_util=get_bdd_comptes();
	$retour=false;
	foreach ($liste_util as $key => $val){
		if ($mail == $val["EMAIL"] && $val["PASS"] == $pass){
			$retour = true;
		}
    }
	return $retour;
}
?>
