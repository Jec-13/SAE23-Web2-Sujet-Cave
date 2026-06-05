<?php
function get_bdd_comptes($path){
	$retour = false;
	$madb = new PDO('sqlite:'.$path);
	$requete = "SELECT u.EMAIL, u.PASS, u.STATUT
				FROM utilisateurs u";
	$resultat = $madb->query($requete);
	$tableau = $resultat->fetchAll(PDO::FETCH_ASSOC);
	if (sizeof($tableau) != 0) {
		$retour = $tableau;
	}
	return $retour;
};

function get_liste_vins($path){
	$retour = false;
	$madb = new PDO('sqlite:'.$path);
	$requete = "SELECT vins.CRU, vins.COULEUR, vins.ORIGINE, negociants.NOM as 'NOM NEGOCIANT', negociants.REGION as 'REGION NEGOCIANT', cave.NB_BOUTEILLES as 'nombre de bouteilels en stock'
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

function get_element_list($path, $el){
	$retour = false;
	$madb = new PDO('sqlite:'.$path);
	$requete = "SELECT DISTINCT ".$el." FROM vins";
	$resultat = $madb->query($requete);
	$tableau = $resultat->fetchAll(PDO::FETCH_ASSOC);
	if (sizeof($tableau) != 0) {
		$retour = $tableau;
	}
	return $retour;
}

function get_element_by_name($path, $name){
	$retour = false;
	$madb = new PDO('sqlite:'.$path);
	$requete = "SELECT DISTINCT *
				FROM vins
				WHERE CRU='".$name."'";
	$resultat = $madb->query($requete);
	$tableau = $resultat->fetchAll(PDO::FETCH_ASSOC);
	if (sizeof($tableau) != 0) {
		$retour = $tableau;
	}
	return $retour;
}

function get_negoc_by_name($path, $name){
	$retour = false;
	$madb = new PDO('sqlite:'.$path);
	$requete = "SELECT DISTINCT *
				FROM negociants
				WHERE NOM='".$name."'";
	$resultat = $madb->query($requete);
	$tableau = $resultat->fetchAll(PDO::FETCH_ASSOC);
	if (sizeof($tableau) != 0) {
		$retour = $tableau;
	}
	return $retour;
}

function get_vins_by_origin($path, $origine){
	$retour = false;
	$madb = new PDO('sqlite:'.$path);
	$requete = "SELECT vins.CRU, vins.COULEUR, vins.ORIGINE, negociants.NOM as 'NOM NEGOCIANT', negociants.REGION as 'REGION NEGOCIANT', cave.NB_BOUTEILLES as 'nombre de bouteilels en stock'
				FROM cave
				JOIN negociants ON negociants.noN=cave.noN
				JOIN vins on vins.noV=cave.noV
				WHERE vins.ORIGINE='".$origine."'";
	$resultat = $madb->query($requete);
	$tableau = $resultat->fetchAll(PDO::FETCH_ASSOC);
	if (sizeof($tableau) != 0) {
		$retour = $tableau;
	}
	return $retour;
}

function get_liste_vinsnegoc($path){
	$retour = false;
	$madb = new PDO('sqlite:'.$path);
	$requete = "SELECT vins.CRU, negociants.NOM, cave.NB_BOUTEILLES
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


function is_admin($mail, $path){
	$liste_util=get_bdd_comptes($path);
	$retour=false;
	foreach ($liste_util as $key => $val){
		if ($mail == $val["EMAIL"] && $val["STATUT"] == "admin"){
			$retour = true;
		}
    }
	return $retour;
}

function test_connexion($mail, $pass, $path){
	$liste_util=get_bdd_comptes($path);
	$retour="nomail";
	foreach ($liste_util as $key => $val){
		if ($mail == $val["EMAIL"] && $val["PASS"] == $pass){
			$retour = "ok";
		}
		elseif ($mail == $val["EMAIL"]){
			$retour = "nopass";
		}
    }
	return $retour;
}

function modif_element($path, $nb, $cru, $negoc){
	$retour = 0;
	$noV = get_element_by_name($path, $cru)[0]['noV'];
	$noN = get_negoc_by_name($path, $negoc)[0]['noN'];
	try {
		$madb = new PDO('sqlite:'.$path);
		$madb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$stmt = $madb->prepare("UPDATE cave SET NB_BOUTEILLES = :NB_BOUTEILLES WHERE noV = :noV AND noN = :noN");
		$stmt->bindParam(':NB_BOUTEILLES', $nb);
		$stmt->bindParam(':noV', $noV);
		$stmt->bindParam(':noN', $noN);
		$stmt->execute();
		if ($stmt->rowCount() > 0) $retour = 1;
	} catch (PDOException $e) {
		$retour = 0;
	}
	return $retour;
}

function afficheTableau($tab){
    echo '<table>';	
    echo '<tr>';
    foreach($tab[0] as $colonne => $valeur){
        echo "<th>$colonne</th>";
    }
    echo "</tr>\n";

    foreach($tab as $ligne){
        echo '<tr>';
        foreach($ligne as $colonne => $cellule){
            if($colonne == 'CRU'){
                echo "<td><img src='IMAGES/".$cellule.".jpg' width='100px'/>" . $cellule . "</td>";
            } else {
                echo "<td>" . $cellule . "</td>";
            }
        }
        echo "</tr>\n";
    }
    echo '</table>';
}

?>
